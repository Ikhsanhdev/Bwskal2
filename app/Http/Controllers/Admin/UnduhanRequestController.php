<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\UnduhanAccessMail;
use App\Models\Unduhan;
use App\Models\UnduhanAkses;
use AyatKyo\Klorovel\Core\Facades\KlorovelEncryption;
use AyatKyo\Klorovel\DataTable\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class UnduhanRequestController extends Controller
{
    public $viewPath = 'admin.unduhan.request.';

    public function datatable(Request $request)
    {
        $data = UnduhanAkses::select([
            UnduhanAkses::table('id'),
            UnduhanAkses::table('name'),
            UnduhanAkses::table('email'),
            UnduhanAkses::table('status'),
            Unduhan::table('title as unduhan_title'),
        ])
            ->leftJoin(Unduhan::table(), Unduhan::table('id'), '=', UnduhanAkses::table('unduhan_id'))
            ->orderBy(DB::raw("CASE WHEN " . UnduhanAkses::table('status') . " = 'pending' THEN 1 ELSE 0 END"), 'DESC')
            ->orderBy(UnduhanAkses::table('created_at'), 'ASC');

        $datatable = DataTables::makeWithSearch($data, [
            UnduhanAkses::table('name'),
            UnduhanAkses::table('email'),
        ]);

        return $datatable->toJson();
    }

    public function detail(Request $request)
    {
        $permohonan = UnduhanAkses::with('unduhan')
            ->whereId($request->id)
            ->first();
        if (!$permohonan) {
            return $this->jsonError('Data tidak ditemukan');
        }

        return $this->view('modal-detail', [
            'data'    => $permohonan,
            'unduhan' => $permohonan->unduhan,
        ]);
    }

    public function verify(Request $request)
    {
        $input = validator($request->all(), [
            'id'      => 'required|integer',
            'status'  => 'required|in:approve,reject',
            'message' => 'nullable',
        ]);

        $permohonan = UnduhanAkses::with('unduhan')->whereId($request->id)->first();
        if (!$permohonan) {
            return $this->jsonError('Data tidak ditemukan');
        }

        try {
            DB::beginTransaction();

            $permohonan->admin_message = $request->message;
            $permohonan->status = $request->status;
            $permohonan->save();

            $downloadLink = URL::signedRoute('direktori.download', [
                'slug' => $permohonan->unduhan->slug,
                'bws'  => KlorovelEncryption::encrypt($permohonan->id, 'unduhan'),
            ]);

            Mail::to($permohonan->email)->send(new UnduhanAccessMail([
                'data' => $permohonan,
                'link' => $downloadLink,
            ]));

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->jsonError([$th, 'Verifikasi gagal, coba lagi']);
        }

        return $this->jsonSuccess('Verifikasi berhasil');
    }
}
