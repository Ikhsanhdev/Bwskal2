<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use AyatKyo\Klorovel\DataTable\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class AnnouncementController extends Controller
{
    protected $viewPath = 'admin.announcement.';
    protected $uploadPath = 'uploads/announcement/';

    public function datatable(Request $request)
    {
        $data = Announcement::select([
            Announcement::table('id'),
            Announcement::table('title'),
            Announcement::table('updated_at'),
            Announcement::table('active_from'),
            Announcement::table('active_to'),
            ])
            ->orderBy(Announcement::table('created_at'), 'DESC');

        $datatable = DataTables::makeWithSearch($data, [
            Announcement::table('title'),
            ])
            ->addColumn('active_at', function ($item) {
                $tMulai = $item->active_from->isoFormat('DD MMMM YYYY');
                $tSelesai = $item->active_to->isoFormat('DD MMMM YYYY');
                
                if ($tMulai == $tSelesai) {
                    $waktu = $tMulai;
                } else {
                    $waktu = $tMulai . ' - ' . $tSelesai;
                }

                return $waktu;
            })
            ->removeColumn('active_from')
            ->removeColumn('active_to');
        
        return $datatable->toJson();
    }

    public function create(Request $request)
    {
        return $this->view('form');
    }

    public function edit(Request $request, $id)
    {
        $data = Announcement::whereId($id)->first();
        if (! $data) {
            return redirect()
                ->route('admin.announcement.index')
                ->with('error', 'Pengumuman tidak ditemukan');
        }

        $tMulai = $data->active_from->format('d:m:Y');
        $tSelesai = $data->active_to->format('d:m:Y');
        
        if ($tMulai == $tSelesai) {
            $waktu = $tMulai;
        } else {
            $waktu = $tMulai . ' - ' . $tSelesai;
        }

        return $this->view('form', [
            'data' => $data,
            'waktu' => $waktu,
        ]);
    }

    public function store(Request $request)
    {
        $validasi = validator($request->all(), [
            'title'    => 'required|min:3',
            'content'  => 'required',
            'tgl_aktif' => 'required',
        ]);
        $this->responseFailsValidation($validasi);

        try {
            DB::beginTransaction();

            $announcement = new Announcement();
            $announcement->user_id = Auth::id();
            $announcement->title = $request->title;
            $announcement->slug = slug_with_random_number($announcement->title);
            $announcement->content = $request->content;

            //  Proses tanggal aktif
            $waktuPecah = explode(' - ', $request->tgl_aktif);
            $announcement->active_from = Carbon::createFromFormat('d:m:Y', $waktuPecah[0])->startOfDay();
            $announcement->active_to = Carbon::createFromFormat('d:m:Y', $waktuPecah[1])->startOfDay();

            //  Proses cover
            if ($request->cover) {
                $cover = Image::make($request->cover);
                $coverName = generate_filename('png', $announcement->title);
                $coverPath = $this->uploadPath . $coverName;
                $cover->save($coverPath);
                $cover->fit(350, 250)->save($this->uploadPath . 'thumbs_' . $coverName);

                $announcement->cover = $coverName;
            }
            
            $announcement->save();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            if (isset($coverName)) {
                try_delete_if_exists($this->uploadPath . $coverName);
                try_delete_if_exists($this->uploadPath . 'thumbs_' . $coverName);
            }

            return $this->jsonError([$th, "Gagal menyimpan Pengumuman"]);
        }
        
        return $this->jsonSuccess("Berhasil menyimpan Pengumuman", [
            'redir' => route('admin.announcement.index'),
        ]);
    }

    public function update(Request $request)
    {
        $validasi = validator($request->all(), [
            '_id'       => 'required|integer',
            'title'     => 'required|min:3',
            'content'   => 'required',
            'tgl_aktif' => 'required',
        ]);
        $this->responseFailsValidation($validasi);

        $announcement = Announcement::whereId($request->_id)->first();
        if (!$announcement) {
            return $this->jsonError('Pengumuman tidak ditemukan');
        }

        try {
            DB::beginTransaction();
            
            $announcement->title = $request->title;
            $announcement->content = $request->content;

            //  Proses tanggal aktif
            $waktuPecah = explode(' - ', $request->tgl_aktif);
            $announcement->active_from = Carbon::createFromFormat('d:m:Y', $waktuPecah[0])->startOfDay();
            $announcement->active_to = Carbon::createFromFormat('d:m:Y', $waktuPecah[1])->startOfDay();

            if ($request->cover) {
                $cover = Image::make($request->cover);
                $coverName = generate_filename('png', $announcement->title);
                $coverPath = $this->uploadPath . $coverName;
                $cover->save($coverPath);
                $cover->fit(350, 250)->save($this->uploadPath . 'thumbs_' . $coverName);

                $coverOld = $announcement->cover;
                $announcement->cover = $coverName;
            }

            $announcement->save();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            if (isset($coverName)) {
                try_delete_if_exists($this->uploadPath . $coverName);
                try_delete_if_exists($this->uploadPath . 'thumbs_' . $coverName);
            }

            return $this->jsonError([$th, "Gagal memperbaharui Pengumuman"]);
        }

        if (isset($coverOld)) {
            try_delete_if_exists($this->uploadPath . $coverOld);
            try_delete_if_exists($this->uploadPath . 'thumbs_' . $coverOld);
        }

        $res = [];
        if (isset($coverPath)) {
            $res['redir'] = route('admin.announcement.edit', ['id' => $announcement->id]);
        }
        
        return $this->jsonSuccess("Berhasil memperbaharui Pengumuman", $res);
    }

    public function destroy(Request $request)
    {
        $validasi = validator($request->all(), [
            'id' => 'required|integer',
        ]);
        $this->responseFailsValidation($validasi);

        $data = Announcement::hasId($request->id)->first();
        if (! $data) {
            return $this->jsonError('Pengumuman tidak ditemukan');
        }

        if (! $data->delete()) {
            return $this->jsonError('Gagal menghapus Pengumuman');
        }

        if ($data->cover) {
            try_delete_if_exists($this->uploadPath . $data->cover);
            try_delete_if_exists($this->uploadPath . 'thumbs_' . $data->cover);
        }

        return $this->jsonSuccess('Berhasil menghapus Pengumuman');
    }
}
