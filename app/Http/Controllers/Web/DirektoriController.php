<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Unduhan;
use App\Models\UnduhanAkses;
use App\Models\UnduhanKategori;
use AyatKyo\Klorovel\Core\Facades\KlorovelEncryption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class DirektoriController extends Controller
{
    public $viewPath = 'web.direktori.';

    public function index(Request $request)
    {
        if (isset($_GET['request_sent'])) {
            return $this->view('request-sent');
        }

        $list = Unduhan::select([
            Unduhan::table('title'),
            Unduhan::table('slug'),
            Unduhan::table('mime'),
            Unduhan::table('hit'),
            Unduhan::table('created_at'),
            Unduhan::table('is_private'),
            UnduhanKategori::table('name as kategori_name'),
            UnduhanKategori::table('slug as kategori_slug'),
        ])->joinKategori();

        $kategoriList = UnduhanKategori::select('id', 'name')->get();

        $dataFiltered = false;
        $filterQuery = [];

        if (isset($_GET['q']) && strlen($_GET['q']) > 0) {
            $dataFiltered = true;
            $filterQuery['q'] = $_GET['q'];
            $list = $list->where(Unduhan::table('title'), 'like', '%' . $filterQuery['q'] . '%');
        }

        if (isset($_GET['kategori'])) {
            $filterQuery['kategori'] = $_GET['kategori'];
            if ($filterQuery != 'all') {
                $dataFiltered = true;
                $list = $list->where(Unduhan::table('category_id'), '=', $filterQuery['kategori']);
            }
        }

        $list = $list->paginate(20);

        return $this->view('index', [
            'list'         => $list,
            'kategoriList' => $kategoriList,
            'filterQuery'  => $filterQuery,
            'dataFiltered' => $dataFiltered,
        ]);
    }

    public function download(Request $request, $slug)
    {
        $unduhan = Unduhan::whereSlug($slug)->firstOrFail();

        //  Cek apakah file masih ada
        if (!File::exists($unduhan->file_path)) {
            return view('errors.web', [
                'title' => '404 Not Found',
                'message' => '404 Not Found',
                'submessage' => "Berkas tidak ditemukan atau sudah dihapus oleh admin",
            ]);
        }

        //  private file
        if ($unduhan->is_private) {
            //  Tampilkan form
            if (!$request->signature && !$request->bws) {
                return $this->view('request', [
                    'unduhan' => $unduhan,
                ]);
            }

            try {
                //  cek Valid
                if (!$request->hasValidSignature()) {
                    throw new \Exception("Invalid URL");
                }

                //  Cek permohonan
                $permohonan = UnduhanAkses::whereId(KlorovelEncryption::decrypt($request->bws, 'unduhan'))
                    ->whereStatus(UnduhanAkses::STATUS_APPROVE)
                    ->firstOrFail();
            } catch (\Throwable $th) {
                return view('errors.web', [
                    'title' => '404 Not Found',
                    'message' => '404 Not Found',
                    'submessage' => "Tautan yang anda tuju sudah kadaluwarsa atau tidak valid",
                ]);
            }
        }

        //  Increment hit
        $unduhan->timestamps = false;
        $unduhan->increment('hit');
        $unduhan->timestamps = true;

        //  proses download 
        return response()->download($unduhan->file_path);
    }

    public function request(Request $request)
    {
        $request->mergeIfMissing($request->route()->parameters);
        $input = validator($request->all(), [
            'name'                 => 'required',
            'email'                => 'required|email',
            'message'              => 'required',
            'g-recaptcha-response' => 'required|captcha',
        ]);

        //  Cari yang sudah ada
        $unduhan = Unduhan::whereSlug($request->slug)->first();
        $unduhanAkses = UnduhanAkses::whereUnduhanId($unduhan->id)
            ->whereStatus(UnduhanAkses::STATUS_PENDING)
            ->whereEmail($request->email)
            ->first();
        if ($unduhanAkses) {
            return $this->jsonError('Anda sudah pernah melakukan permohonan pada dokumen ini, silakan menunggu permintaan tersebut ditindak lanjuti oleh admin');
        }
        
        //  Buat permohonan
        $permohonan = new UnduhanAkses();
        $permohonan->unduhan_id = $unduhan->id;
        $permohonan->name       = $request->name;
        $permohonan->email      = $request->email;
        $permohonan->message    = $request->message;

        if (!$permohonan->save()) {
            return $this->jsonError('Gagal mengirim permohonan, coba lagi');
        }

        return $this->jsonSuccess('Permohonan berhasil dikirim', [
            'redir' => route('direktori.index') . "?request_sent",
        ]);
    }
}
