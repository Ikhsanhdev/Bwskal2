<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public $viewPath = 'web.gallery.';

    public function list(Request $request, $type)
    {
        $typeWhere = [$type];
        if ($type == 'image') {
            $typeWhere[] = 'album';
        }

        $list = Gallery::select([
            Gallery::table('id'),
            Gallery::table('slug'),
            Gallery::table('type'),
            Gallery::table('name'),
            Gallery::table('content'),
            Gallery::table('description'),
            Gallery::table('created_at'),
            ])
            ->whereIn('type', $typeWhere)
            ->whereAlbum(null)
            ->latest()
            ->paginate(12);

        return $this->view('index', [
            'type' => $type,
            'list' => $list,
        ]);
    }

    public function album(Request $request, $slug)
    {
        //  find album
        $album = Gallery::whereSlug($slug)->first();
        if (! $album) {
            return view('errors.web', [
                'icon'    => 'mdi-file-hidden',
                'title'   => '404 NOT FOUND',
                'message' => 'Album Tidak Ditemukan',
                'submessage' => 'Tautan yang anda tuju tidak valid atau album sudah tidak tersedia',
            ]);
        }

        //  Ambil item pada album
        $list = Gallery::select([
            Gallery::table('id'),
            Gallery::table('slug'),
            Gallery::table('type'),
            Gallery::table('name'),
            Gallery::table('content'),
            Gallery::table('description'),
            Gallery::table('created_at'),
            ])
            ->whereIn(Gallery::table('type'), ['image'])
            ->whereAlbum($album->id)
            ->latest()
            ->paginate(12);

        return $this->view('album', [
            'album' => $album,
            'list'  => $list,
        ]);
    }
}
