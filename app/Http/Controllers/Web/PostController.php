<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function list(Request $request)
    {
        $list = Post::select([
            Post::table('title'),
            Post::table('slug'),
            Post::table('created_at'),
            Post::table('hit_total'),
            Post::table('content'),
            Post::table('cover'),
            User::table('fullname as author'),
            PostCategory::table('slug as category_slug'),
            PostCategory::table('name as category_name'),
        ])
            ->joinUser()
            ->joinCategory()
            ->where(Post::table('status'), Post::STATUS_PUBLISH)
            ->orderBy('created_at', 'DESC')
            ->paginate(9);

        $category = (object) [
            'slug' => 'all',
            'name' => 'Semua Kategori'
        ];
        $categories = PostCategory::select('slug', 'name')
            ->orderBy('is_default', 'DESC')
            ->orderBy('id', 'ASC')
            ->get();

        return view('web.berita', compact('list', 'category', 'categories'));
    }

    public function getDetail(Request $request, $tahun, $bulan, $slug)
    {
        $data = Post::select([
            Post::table('*'),
            User::table('fullname as author'),
            PostCategory::table('name as category_name'),
            PostCategory::table('slug as category_slug'),
        ])
            ->where(Post::table('slug'), $slug)
            ->whereMonth(Post::table('created_at'), $bulan)
            ->whereYear(Post::table('created_at'), $tahun)
            ->where(Post::table('status'), Post::STATUS_PUBLISH)
            ->joinUser()
            ->joinCategory()
            ->first();

        if (!$data) {
            return abort(404);
        }

        //  Update hit
        $cSekarang = now();
        $cWeek = $cSekarang->week();
        $data->hit_total += 1;

        if ($cWeek != $data->hit_week) {
            $data->hit_week = $cWeek;
            $data->hit_week_total = 1;
        } else {
            $data->hit_week_total += 1;
        }

        $data->timestamps = false;
        $data->save();
        $data->timestamps = true;

        return view('web.berita-detail', compact('data', 'tahun', 'bulan', 'slug'));
    }

    public function getCategory(Request $request, $slug)
    {
        $category = PostCategory::whereSlug($slug)->first();
        if (! $category) {
            return abort(404);
        }

        $list = Post::select([
            Post::table('title'),
            Post::table('slug'),
            Post::table('created_at'),
            Post::table('hit_total'),
            Post::table('content'),
            Post::table('cover'),
            User::table('fullname as author'),
            PostCategory::table('slug as category_slug'),
            PostCategory::table('name as category_name'),
        ])
            ->joinUser()
            ->joinCategory()
            ->whereCategoryId($category->id)
            ->where(Post::table('status'), Post::STATUS_PUBLISH)
            ->orderBy('created_at', 'DESC')
            ->paginate(9);

        $categories = PostCategory::select('slug', 'name')
            ->orderBy('is_default', 'DESC')
            ->orderBy('id', 'ASC')
            ->get();

        return view('web.berita', compact('list', 'category', 'categories'));
    }
}
