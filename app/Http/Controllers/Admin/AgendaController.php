<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use AyatKyo\Klorovel\DataTable\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AgendaController extends Controller
{
    public $viewPath = 'admin.agenda.';

    public function datatable(Request $request)
    {
        $data = Agenda::select([
            Agenda::table('id'),
            Agenda::table('title'),
            Agenda::table('location'),
            Agenda::table('begin_at'),
            Agenda::table('end_at'),
            Agenda::table('updated_at'),
        ])->orderBy(Agenda::table('created_at'), 'DESC');

        $datatable = DataTables::makeWithSearch($data, [
            Agenda::table('title'),
            ])
            ->addColumn('active_at', function ($item) {
                $tMulai = $item->begin_at->isoFormat('DD MMMM YYYY');
                $tSelesai = $item->end_at->isoFormat('DD MMMM YYYY');
                
                if ($tMulai == $tSelesai) {
                    $waktu = $tMulai;
                } else {
                    $waktu = $tMulai . ' - ' . $tSelesai;
                }

                return $waktu;
            })
            ->removeColumn('begin_at')
            ->removeColumn('end_at');
        
        return $datatable->toJson();
    }

    public function create(Request $request)
    {
        return $this->view('modal-form');
    }

    public function store(Request $request)
    {
        $validasi = validator($request->all(), [
            'title'    => 'required|min:3',
            'location' => 'required',
            'tanggal'  => 'required',
            'lampiran' => 'sometimes|file|mimetypes:' . Agenda::getUploadMimes(),
        ], [
            'lampiran.mimetypes' => Agenda::getUploadMimesMessage(),
        ]);
        $this->responseFailsValidation($validasi);

        try {
            DB::beginTransaction();

            $agenda = new Agenda();
            $agenda->user_id = Auth::id();
            $agenda->title = $request->title;
            $agenda->slug = slug_with_random_number($agenda->title);
            $agenda->location = $request->location;
            $agenda->description = $request->description;

            //  proses waktu
            $waktuPecah = explode(",", $request->tanggal);
            $agenda->begin_at = Carbon::createFromFormat('d-m-Y', $waktuPecah[0])->startOfDay();
            $agenda->end_at = Carbon::createFromFormat('d-m-Y', $waktuPecah[1])->endOfDay();
            
            //  Proses lampiran
            if ($request->lampiran) {
                $lampiran = $request->lampiran;
                $lampiranName = generate_filename($lampiran, $agenda->title);
                $lampiran->move(Agenda::UPLOAD_PATH, $lampiranName);
                $agenda->attachment = $lampiranName;
            }

            $agenda->save();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            if (isset($lampiranName)) {
                try_delete_if_exists(Agenda::UPLOAD_PATH . $lampiranName);
            }
            return $this->jsonError([$th, "Gagal membuat agenda"]);
        }
        
        return $this->jsonSuccess("Berhasil membuat agenda");
    }

    public function edit(Request $request)
    {
        $data = Agenda::whereId($request->id)->first();
        if (!$data) {
            return $this->jsonError('Agenda tidak ditemukan');
        }

        $data->tanggal = [
            $data->begin_at->isoFormat('DD-MM-YYYY'),
            $data->end_at->isoFormat('DD-MM-YYYY'),
        ];

        return $this->view('modal-form', compact('data'));
    }

    public function update(Request $request)
    {
        $validasi = validator($request->all(), [
            '_id'      => 'required|integer',
            'title'    => 'required|min:3',
            'location' => 'required',
            'tanggal'  => 'required',
            'lampiran' => 'sometimes|file|mimetypes:' . Agenda::getUploadMimes(),
        ], [
            'lampiran.mimetypes' => Agenda::getUploadMimesMessage(),
        ]);
        $this->responseFailsValidation($validasi);
        
        $agenda = Agenda::whereId($request->_id)->first();
        if (!$agenda) {
            return $this->jsonError('Agenda tidak ditemukan');
        }
        
        try {
            DB::beginTransaction();

            $agenda->title = $request->title;
            $agenda->location = $request->location;
            $agenda->description = $request->description;

            //  proses waktu
            $waktuPecah = explode(",", $request->tanggal);
            $agenda->begin_at = Carbon::createFromFormat('d-m-Y', $waktuPecah[0])->startOfDay();
            $agenda->end_at = Carbon::createFromFormat('d-m-Y', $waktuPecah[1])->endOfDay();
            
            //  Proses lampiran
            if ($request->lampiran) {
                $lampiran = $request->lampiran;
                $lampiranName = generate_filename($lampiran, $agenda->title);
                $lampiran->move(Agenda::UPLOAD_PATH, $lampiranName);
                $lampiranOld = $agenda->attachment;
                $agenda->attachment = $lampiranName;
            } else if ($request->lampiran_deleted) {
                $lampiranOld = $agenda->attachment;
                $agenda->attachment = null;
            }

            $agenda->save();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            if (isset($lampiranName)) {
                try_delete_if_exists(Agenda::UPLOAD_PATH . $lampiranName);
            }
            return $this->jsonError([$th, "Gagal memperbaharui agenda"]);
        }

        if (isset($lampiranOld) && $lampiranOld) {
            try_delete_if_exists(Agenda::UPLOAD_PATH . $lampiranOld);
        }
        
        return $this->jsonSuccess("Berhasil memperbaharui agenda");
    }

    public function destroy(Request $request)
    {
        $validasi = validator($request->all(), [
            'id' => 'required|integer',
        ]);
        $this->responseFailsValidation($validasi);
        
        $data = Agenda::hasId($request->id)->first();
        
        if (! $data) {
            return $this->jsonError('Agenda tidak ditemukan');
        }

        if (! $data->delete()) {
            return $this->jsonError('Gagal menghapus agenda');
        }

        if ($data->attachment) {
            try_delete_if_exists(Agenda::UPLOAD_PATH . $data->attachment);
        }

        return $this->jsonSuccess('Berhasil menghapus agenda');
    }
}
