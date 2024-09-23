<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Slide;
use AyatKyo\Klorovel\DataTable\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class SlideController extends Controller
{
    protected $viewPath = 'admin.slide.';
    protected $uploadPath = 'uploads/slide/';

    public function datatable(Request $request)
    {
        $data = Slide::select([
            Slide::table('id'),
            Slide::table('type'),
            DB::raw("COALESCE(" . Post::table('title') . ", " . Slide::table("title") . ") as title"),
            DB::raw("IF(" . Slide::table('type') . " = 'image', " . Slide::table("value") . ", " . Post::table("cover") . ") as value"),
            Slide::table('featured_at'),
            Slide::table('updated_at'),
        ])
            ->leftJoin(Post::table(), function ($join) {
                $join->on(Slide::table('value'), '=', Post::table('id'))
                    ->where(Slide::table('type'), 'post')
                    ->where(Post::table('status'), Post::STATUS_PUBLISH);
            })
            ->orderByRaw('-' . Slide::table('featured_position') . ' DESC')
            ->orderBy(Slide::table('created_at'), 'DESC');

        $datatable = DataTables::of($data)
            ->addIndexColumn()
            ->filter(function ($query) {
                if (request()->has('search') && isset(request()->get('search')['value'])) {
                    $query->having('title', 'like', "%" . request()->get('search')['value'] . "%");
                }
            }, true);

        return $datatable->toJson();
    }

    public function create(Request $request)
    {
        return $this->view('modal-form', []);
    }

    public function edit(Request $request)
    {
        $data = Slide::hasId($request->id)->first();
        if (!$data) {
            return $this->jsonError('Slide tidak ditemukan');
        }

        return $this->view('modal-form', [
            'data' => $data,
        ]);
    }

    public function store(Request $request)
    {
        $method = Str::slug($request->tipe, '_');
        if (method_exists($this, 'store_' . $method)) {
            return $this->{'store_' . $method}($request);
        }

        return $this->jsonError("Gagal menyimpan data, handler '{$request->tipe}' tidak ditemukan");
    }

    public function store_image(Request $request)
    {
        $validasi = validator($request->all(), [
            'judul'  => 'required',
            'gambar' => 'required',
        ]);
        $this->responseFailsValidation($validasi);

        $slide = new Slide;
        $slide->user_id = Auth::user()->id;
        $slide->type = 'image';
        $slide->title = $request->judul;
        $slide->link = $request->link;
        $slide->show_title = $request->has('judul_tampil');

        try {
            $gambar = Image::make($request->gambar);
            $gambarName = generate_filename('png', $slide->title);
            $gambar->save($this->uploadPath . $gambarName);
            $gambar->fit(250, 250)->save($this->uploadPath . 'thumbs_' . $gambarName);

            $slide->value = $gambarName;
            $slide->save();
        } catch (\Throwable $th) {
            if (isset($gambarName)) {
                try_delete_if_exists($this->uploadPath . $gambarName);
                try_delete_if_exists($this->uploadPath . 'thumbs_' . $gambarName);
            }

            return $this->jsonError([$th, 'Gagal menyimpan slide']);
        }

        return $this->jsonSuccess('Berhasil menyimpan slide');
    }

    public function store_post(Request $request)
    {
        $validasi = validator($request->all(), [
            'post_id'  => 'required',
        ]);
        $this->responseFailsValidation($validasi);
        
        //  Cari apakah sudah ada slide ini
        $slide = Slide::whereType('post')
            ->whereValue($request->post_id)
            ->first();
        if ($slide) {
            return $this->jsonError('Berita ini sudah pernah dijadikan slide');
        }

        //  Cek berita
        $post = Post::whereId($request->post_id)
            ->where(Post::table('status'), Post::STATUS_PUBLISH)
            ->first();
        if (!$post) {
            return $this->jsonError('Berita terpilih tidak ditemukan');
        }

        $slide = new Slide;
        $slide->user_id = Auth::id();
        $slide->type = 'post';
        $slide->value = $post->id;

        if (!$slide->save()) {
            return $this->jsonError('Gagal menyimpan slide');
        }

        return $this->jsonSuccess('Berhasil menyimpan slide');
    }

    public function update(Request $request)
    {
        $method = Str::slug($request->tipe, '_');
        if (method_exists($this, 'update_' . $method)) {
            return $this->{'update_' . $method}($request);
        }

        return $this->jsonError("Gagal memperbaharui data, handler '{$request->tipe}' tidak ditemukan");
    }

    public function update_image(Request $request)
    {
        $validasi = validator($request->all(), [
            '_id'    => 'required|integer',
            'judul'  => 'required',
        ]);
        $this->responseFailsValidation($validasi);

        $slide = Slide::hasId($request->_id)
            ->whereType('image')
            ->first();
        if (!$slide) {
            return $this->jsonError('Slide tidak ditemukan');
        }

        try {
            $slide->title = $request->judul;
            $slide->link = $request->link;
            $slide->show_title = $request->has('judul_tampil');

            if ($request->gambar) {
                $gambar = Image::make($request->gambar);
                $gambarName = generate_filename('png', $slide->title);
                $gambar->save($this->uploadPath . $gambarName);
                $gambar->fit(250, 250)->save($this->uploadPath . 'thumbs_' . $gambarName);
                $gambarOld = $slide->value;
                $slide->value = $gambarName;
            }

            $slide->save();
        } catch (\Throwable $th) {
            if (isset($gambarName)) {
                try_delete_if_exists($this->uploadPath . $gambarName);
                try_delete_if_exists($this->uploadPath . 'thumbs_' . $gambarName);
            }

            return $this->jsonError([$th, "Gagal memperbaharui slide"]);
        }

        if (isset($gambarOld)) {
            try_delete_if_exists($this->uploadPath . $gambarOld);
            try_delete_if_exists($this->uploadPath . 'thumbs_' . $gambarOld);
        }

        return $this->jsonSuccess("Berhasil memperbaharui slide");
    }

    public function update_post(Request $request)
    {
        $validasi = validator($request->all(), [
            '_id'     => 'required|integer',
            'post_id' => 'required',
        ]);
        $this->responseFailsValidation($validasi);

        //  Cek slide
        $slide = Slide::whereId($request->_id)
            ->whereType('post')
            ->first();
        if (!$slide) {
            return $this->jsonError('Slide tidak ditemukan');
        }

        //  Cari apakah sudah ada slide ini
        $slideAda = Slide::whereType('post')
            ->whereValue($request->post_id)
            ->whereNotIn('id', [$slide->id])
            ->first();
        if ($slideAda) {
            return $this->jsonError('Berita ini sudah pernah dijadikan slide');
        }

        //  Cek berita
        $post = Post::whereId($request->post_id)    
            ->where(Post::table('status'), Post::STATUS_PUBLISH)
            ->first();
        if (!$post) {
            return $this->jsonError('Berita terpilih tidak ditemukan');
        }

        $slide->value = $post->id;

        if (!$slide->save()) {
            return $this->jsonError('Gagal memperbaharui slide');
        }

        return $this->jsonSuccess('Berhasil memperbaharui slide');
    }

    public function destroy(Request $request)
    {
        $validasi = validator($request->all(), [
            'id' => 'required|integer',
        ]);
        $this->responseFailsValidation($validasi);

        $item = Slide::hasId($request->id)->first();
        if (!$item) {
            return $this->jsonError('Slide tidak ditemukan');
        }

        if (!$item->delete()) {
            return $this->jsonError('Gagal menghapus slide');
        }

        if ($item->type == 'image') {
            try_delete_if_exists($this->uploadPath . $item->value);
            try_delete_if_exists($this->uploadPath . 'thumbs_' . $item->value);
        }

        return $this->jsonSuccess('Berhasil menghapus slide');
    }

    public function postPostList(Request $request)
    {
        //  Ambil 25 post terbaru
        $postList = Post::select([
            'id',
            'cover',
            'title',
            'created_at',
        ]);

        if ($request->selected) {
            $postList = $postList->orderByRaw('id <> ' . $request->selected);
        }

        $postList = $postList->orderBy('created_at', 'DESC');
        $postList = $postList->limit(25)
            ->where(Post::table('status'), Post::STATUS_PUBLISH)
            ->get();

        // Kaitkan dengan penulis

        return $this->jsonSuccess('', [
            'data' => [
                'list' => $postList,
            ]
        ]);
    }
}
