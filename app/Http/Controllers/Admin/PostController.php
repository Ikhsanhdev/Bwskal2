<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\User;
use AyatKyo\Klorovel\DataTable\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class PostController extends Controller
{
    public $viewPath = 'admin.post.';
    protected $uploadPath = 'uploads/post/';

    public function index(Request $request)
    {
        $kategoriList = PostCategory::select('id', 'name')
            ->orderBy('is_default', 'DESC')
            ->orderBy('id', 'ASC')
            ->get()
            ->mapWithKeys(fn ($item) => [$item->id => $item->name])
            ->prepend('Semua Kategori', 'all');

        return $this->view('index', [
            'kategoriList' => $kategoriList,
        ]);
    }

    public function datatable(Request $request)
    {
        $data = Post::select([
            Post::table('id'),
            Post::table('title'),
            Post::table('updated_at'),
            Post::table('status'), 
            User::table('fullname as author'), 
            PostCategory::table('name as category_name'),
        ])
            ->join(User::table(), User::table('id'), '=', Post::table('user_id'))
            ->join(PostCategory::table(), PostCategory::table('id'), '=', Post::table('category_id'))
            ->orderBy(Post::table('created_at'), 'DESC')
            ->when($request->f_status !== 'all', function ($query) use ($request) {
                $query->where(Post::table('status'), $request->f_status);
            })
            ->when($request->f_category !== 'all', function ($query) use ($request) {
                $query->whereCategoryId($request->f_category);
            });

        $datatable = DataTables::makeWithSearch($data, [
            Post::table('title'),
            User::table('fullname'),
        ]);
        
        return $datatable->toJson();
    }

    public function create(Request $request)
    {
        $kategoriList = PostCategory::select('id', 'name')
            ->orderBy('is_default', 'DESC')
            ->orderBy('id', 'ASC')
            ->get()
            ->mapWithKeys(fn ($item) => [$item->id => $item->name]);

        return $this->view('form', [
            'kategoriList' => $kategoriList,
        ]);
    }

    public function edit(Request $request, $id)
    {
        $data = Post::whereId($id)->first();
        if (! $data) {
            return redirect()
                ->route('admin.post.index')
                ->with('error', 'Berita tidak ditemukan');
        }

        $kategoriList = PostCategory::select('id', 'name')
            ->orderBy('is_default', 'DESC')
            ->orderBy('id', 'ASC')
            ->get()
            ->mapWithKeys(fn ($item) => [$item->id => $item->name]);

        return $this->view('form', [
            'data'         => $data,
            'kategoriList' => $kategoriList,
        ]);
    }

    public function store(Request $request)
    {
        $validasi = validator($request->all(), [
            'title'    => 'required|min:3',
            'category' => 'required|integer',
            'content'  => 'required',
        ]);
        $this->responseFailsValidation($validasi);

        try {
            DB::beginTransaction();

            //  Create Berita
            $post = new Post();
            $post->user_id = Auth::id();
            $post->category_id = $request->category;
            $post->title = $request->title;
            $post->slug = slug_with_random_number($post->title);
            $post->content = $request->content;
            $post->status = $request->save_status && $request->save_status == Post::STATUS_DRAFT ? Post::STATUS_DRAFT : Post::STATUS_PUBLISH;

            //  Proses cover
            if ($request->cover) {
                $cover = Image::make($request->cover);
                $coverName = generate_filename('png', $post->title);
                $coverPath = $this->uploadPath . $coverName;
                $cover->save($coverPath);
                $cover->fit(350, 250)->save($this->uploadPath . 'thumbs_' . $coverName);

                $post->cover = $coverName;
            }

            $post->save();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            if (isset($coverName)) {
                try_delete_if_exists($this->uploadPath . $coverName);
                try_delete_if_exists($this->uploadPath . 'thumbs_' . $coverName);
            }

            return $this->jsonError([$th, "Gagal menyimpan Berita"]);
        }
        
        return $this->jsonSuccess("Berhasil menyimpan Berita", [
            'redir' => route('admin.post.index'),
        ]);
    }

    public function update(Request $request)
    {
        $validasi = validator($request->all(), [
            '_id'      => 'required|integer',
            'title'    => 'required|min:3',
            'category' => 'required|integer',
            'content'  => 'required',
        ]);
        $this->responseFailsValidation($validasi);

        //  Cari berita
        $post = Post::whereId($request->_id)->first();
        if (!$post) {
            return $this->jsonError('Berita tidak ditemukan');
        }

        try {
            DB::beginTransaction();

            $post->category_id = $request->category;
            $post->title = $request->title;
            $post->content = $request->content;

            $statusBefore = $post->status;
            $post->status = $request->save_status && $request->save_status == Post::STATUS_DRAFT ? Post::STATUS_DRAFT : Post::STATUS_PUBLISH;

            //  Jika dipublish di form edit, ubah created_at nya menjadi waktu sekarang
            if ($statusBefore != Post::STATUS_PUBLISH && $post->status == Post::STATUS_PUBLISH) {
                $post->created_at = now();
            }

            //  Proses cover
            if ($request->cover) {
                $cover = Image::make($request->cover);
                $coverName = generate_filename('png', $post->title);
                $coverPath = $this->uploadPath . $coverName;
                $cover->save($coverPath);
                $cover->fit(350, 250)->save($this->uploadPath . 'thumbs_' . $coverName);

                $coverOld = $post->cover;
                $post->cover = $coverName;
            }
            
            $post->save();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            
            if (isset($coverName)) {
                try_delete_if_exists($this->uploadPath . $coverName);
                try_delete_if_exists($this->uploadPath . 'thumbs_' . $coverName);
            }

            return $this->jsonError([$th, "Gagal memperbaharui Berita"]);
        }

        if (isset($coverOld)) {
            try_delete_if_exists($this->uploadPath . $coverOld);
            try_delete_if_exists($this->uploadPath . 'thumbs_' . $coverOld);
        }

        $res = [];
        if (isset($coverPath) || $statusBefore != $post->status) {
            $res['redir'] = route('admin.post.edit', ['id' => $post->id]);
        }
        
        return $this->jsonSuccess("Berhasil memperbaharui Berita", $res);
    }

    public function destroy(Request $request)
    {
        $validasi = validator($request->all(), [
            'id' => 'required|integer',
        ]);
        $this->responseFailsValidation($validasi);

        $data = Post::hasId($request->id)->first();
        if (! $data) {
            return $this->jsonError('Berita tidak ditemukan');
        }

        if (! $data->delete()) {
            return $this->jsonError('Gagal menghapus berita');
        }

        if ($data->cover) {
            try_delete_if_exists($this->uploadPath . $data->cover);
            try_delete_if_exists($this->uploadPath . 'thumbs_' . $data->cover);
        }

        return $this->jsonSuccess('Berhasil menghapus berita');
    }
}
