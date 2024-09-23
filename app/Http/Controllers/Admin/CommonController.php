<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Gallery;
use App\Models\Infografis;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Unduhan;
use AyatKyo\Klorovel\Visitor\Facades\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class CommonController extends Controller
{
    public function dasbor(Request $request)
    {
        if (isset($_GET['reset'])) {
            Cache::forget('admin-dasbor');
        }

        //  Cache 5 menit
        $statData = Cache::remember('admin-dasbor', 60 * 5, function () {
            return $this->dasborMakeData();
        });

        return $this->view('admin.dasbor.index', [
            'statData' => (object) $statData,
        ]);
    }

    public function dasborMakeData()
    {
        $ret = [
            'visit' => Visitor::getStat(),
        ];

        //  Ambil statistik berita
        $sdaCategory = PostCategory::whereSlug(PostCategory::DITJEN_SDA_SLUG)->first();
        $ret['post_total'] = Post::where('category_id', '!=', $sdaCategory->id)->count('id');
        $ret['post_sda'] = Post::where('category_id', $sdaCategory->id)->count('id');

        //  Statistik Galeri
        $ret['galeri_foto'] = Gallery::whereType('image')->count('id');
        $ret['galeri_video'] = Gallery::whereType('video')->count('id');

        //  Statistik Unduhan
        $ret['unduhan'] = Unduhan::count('id');
        $ret['unduhan_diunduh'] = Unduhan::sum('hit');

        $ret['poster'] = Infografis::count('id');
        $ret['pengumuman'] = Announcement::count('id');

        //  Simpan last update
        $ret['last_update'] = now()->isoFormat("DD MMMM YYYY - HH:mm");

        return $ret;
    }

    public function imageUpload(Request $request)
    {
        //  Validasi
        $validasi = validator($request->all(), [
            'image' => 'required|file|image|max:5120',
        ], [
            'image.image' => 'Berkas harus berupa gambar',
            'image.max'   => 'Maksimal berukuran 5MB',
        ]);

        if ($validasi->fails()) {
            return response()->json([
                'message' => $validasi->errors()->first('image')
            ], 400);
        }

        $user = Auth::user();

        try {
            $gambarNama = generate_filename($request->image, $user->fullname . "_" . random_number(7));
            $request->image->move('uploads/editor', $gambarNama);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 400);
        }

        return response()->json([
            'url' => url('uploads/editor/' . $gambarNama),
        ]);
    }
}
