<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use AyatKyo\Klorovel\DataTable\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class GalleryController extends Controller
{
    public $viewPath = 'admin.gallery.';

    public function getAlbum(Request $requesti, $albumID)
    {
        $album = Gallery::whereType(Gallery::TYPE_ALBUM)
            ->whereId($albumID)
            ->first();

        if (!$album) {
            return $this->jsonError('Album tidak ditemukan');
        }

        $album->album_cover = Gallery::where(Gallery::table('type'), '!=', Gallery::TYPE_ALBUM)
            ->whereContent($album->content)
            ->first();

        return $this->view('album', compact('album'));
    }

    public function datatable(Request $request)
    {
        $data = Gallery::select([
            Gallery::table('id'),
            Gallery::table('name'),
            Gallery::table('type'),
            Gallery::table('created_at'),
            Gallery::table('content'),
            ])
            ->orderBy(Gallery::table('created_at'), 'DESC')
            ->where(Gallery::table('album'), $request->album ?? null);

        $datatable = DataTables::makeWithSearch($data, [
                Gallery::table('name'),
            ])
            ->editColumn('content', function ($item) {
                switch ($item->type) {
                    case Gallery::TYPE_IMAGE:
                        return url(Gallery::UPLOAD_PATH . 'thumbs_' . $item->content);
                        break;
                    case Gallery::TYPE_VIDEO:
                        return 'https://i.ytimg.com/vi/' . $item->content . '/mqdefault.jpg';
                        break;
                    case Gallery::TYPE_ALBUM:
                        return $item->content ? url(Gallery::UPLOAD_PATH . 'thumbs_' . $item->content) : null;
                        break;
                }
            })
            ->filter(function ($query) use ($request) {
                if ($request->type && $request->type != "all") {
                    $query->whereType($request->type);
                }
            })
            ->addColumn('tanggal', function ($item) {
                return $item->created_at->isoFormat('DD MMMM YYYY');
            })
            ->removeColumn('created_at');

        return $datatable->toJson();
    }

    public function create(Request $request)
    {
        if ($request->album_id) {
            $album = Gallery::whereId($request->album_id)->first();
            if (!$album) {
                return $this->jsonError('Album tidak ditemukan');
            }

            return $this->view('modal-form-album', [
                'album' => $album,
            ]);
        }

        return $this->view('modal-form');
    }

    public function edit(Request $request)
    {
        $data = Gallery::whereId($request->id)->first();
        if (!$data) {
            return $this->jsonError('Data tidak ditemukan');
        }

        //  Check album
        if ($request->album_id) {
            $album = Gallery::whereId($request->album_id)->first();
            if (!$album) {
                return $this->jsonError('Album tidak ditemukan');
            }

            return $this->view('modal-form-album', [
                'album' => $album,
                'data'  => $data,
            ]);
        }

        return $this->view('modal-form', compact('data'));
    }

    public function store(Request $request)
    {
        $validasi = validator($request->all(), [
            'name'    => 'required|min:2',
            'type'    => 'required|in:image,video,album',
            'content' => 'required_unless:type,album',
        ]);
        $this->responseFailsValidation($validasi);

        try {
            DB::beginTransaction();

            $gallery = new Gallery;
            $gallery->user_id = Auth::id();
            $gallery->name = $request->name;
            $gallery->slug = slug_with_random_number($gallery->name);
            $gallery->type = $request->type;
            $gallery->description = $request->description;
            $gallery->album = $request->album ?? null;

            switch ($gallery->type) {
                case "video":
                    //  Validasi url youtube
                    preg_match('/https?:\/\/(?:youtu\.be\/|(?:[a-z]{2,3}\.)?youtube\.com\/(?:embed\/|watch(?:\?|#\!)v=))([\w-]{11}).*/mi', $request->content, $yt, PREG_UNMATCHED_AS_NULL);

                    if (!$yt) {
                        return $this->jsonError("Tidak dapat memproses url Youtube");
                    }

                    $gallery->content = $yt[1];
                    break;
                case "image":
                    if (!$request->thumb) {
                        return $this->jsonError("Thumbnail foto tidak ditemukan");
                    }

                    //  Proses Gambar
                    $image = $request->content;
                    $imageThumbs = Image::make($request->thumb);
                    $imageName = generate_filename($image, $gallery->name);

                    //  Simpan
                    $image->move(Gallery::UPLOAD_PATH, $imageName);
                    $imageThumbs->fit(250, 250)->save(Gallery::UPLOAD_PATH . 'thumbs_' . $imageName);
                    $gallery->content = $imageName;

                    if ($request->album && $request->as_cover) {
                        Gallery::whereId($request->album)
                            ->update([
                                'content' => $gallery->content,
                            ]);
                    }
                    break;
                case "album":
                    break;
            }

            $gallery->save();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            if (isset($imageName)) {
                try_delete_if_exists(Gallery::UPLOAD_PATH . $imageName);
                try_delete_if_exists(Gallery::UPLOAD_PATH . 'thumbs_' . $imageName);
            }

            return $this->jsonError('Gagal menyimpan item galeri');
        }

        return $this->jsonSuccess('Berhasil menyimpan item galeri');
    }

    public function update(Request $request)
    {
        $validasi = validator($request->all(), [
            '_id'    => 'required|integer',
            'name'    => 'required|min:2',
            'content' => 'required_if:type,video',
        ]);
        $this->responseFailsValidation($validasi);

        $gallery = Gallery::whereId($request->_id)->first();
        if (!$gallery) {
            return $this->jsonError('Data tidak ditemukan');
        }

        try {
            DB::beginTransaction();

            $gallery->name = $request->name;
            $gallery->description = $request->description;
            $gallery->album = $request->album ?? null;

            if ($request->content) {
                switch ($gallery->type) {
                    case 'video':
                        //  Validasi url youtube
                        preg_match('/https?:\/\/(?:youtu\.be\/|(?:[a-z]{2,3}\.)?youtube\.com\/(?:embed\/|watch(?:\?|#\!)v=))([\w-]{11}).*/mi', $request->content, $yt, PREG_UNMATCHED_AS_NULL);

                        if (!$yt) {
                            throw new \Exception("Tidak dapat memproses url Youtube");
                        }

                        $gallery->content = $yt[1];
                        break;
                    case 'image':
                        if (!!$request->thumbs) {
                            throw new \Exception("Thumbnal foto tidak ditemukan", 1);
                        }

                        //  Proses Gambar
                        $image = $request->content;
                        $imageThumbs = Image::make($request->thumb);
                        $imageName = generate_filename($image, $gallery->name);

                        //  Simpan
                        $image->move(Gallery::UPLOAD_PATH, $imageName);
                        $imageThumbs->fit(250, 250)->save(Gallery::UPLOAD_PATH . 'thumbs_' . $imageName);

                        $imageOld = $gallery->content;
                        $gallery->content = $imageName;
                        break;
                }
            }

            if ($request->album && $request->as_cover) {
                Gallery::whereId($request->album)
                    ->update([
                        'content' => $gallery->content,
                    ]);
            }

            $gallery->save();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            if (isset($imageName)) {
                try_delete_if_exists(Gallery::UPLOAD_PATH . $imageName);
                try_delete_if_exists(Gallery::UPLOAD_PATH . 'thumbs_' . $imageName);
            }

            return $this->jsonError([$th, "Gagal memperbaharui item galeri"]);
        }

        if (isset($imageOld)) {
            try_delete_if_exists(Gallery::UPLOAD_PATH . $imageOld);
            try_delete_if_exists(Gallery::UPLOAD_PATH . 'thumbs_' . $imageOld);
        }

        return $this->jsonSuccess("Berhasil memperbaharui item galeri");
    }

    public function destroy(Request $request)
    {
        $validasi = validator($request->all(), [
            'id' => 'required|integer',
        ]);
        $this->responseFailsValidation($validasi);

        $item = Gallery::hasId($request->id)->first();
        if (!$item) {
            return $this->jsonError('Data tidak ditemukan');
        }

        try {
            DB::beginTransaction();

            if ($item->type == Gallery::TYPE_ALBUM) {
                Gallery::whereAlbum($item->id)
                    ->update([
                        'album' => null,
                    ]);
            } else if ($item->type == Gallery::TYPE_IMAGE && $item->album != null) {
                Gallery::whereId($item->album)
                    ->whereContent($item->content)
                    ->udpate([
                        'content' => null,
                    ]);
            }

            $item->delete();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->jsonError([$th, "Gagal menghapus item"]);
        }

        if ($item->type == Gallery::TYPE_IMAGE) {
            try_delete_if_exists(Gallery::UPLOAD_PATH . $item->content);
            try_delete_if_exists(Gallery::UPLOAD_PATH . 'thumbs_' . $item->content);
        }

        return $this->jsonSuccess('Berhasil menghapus item');
    }

    public function listAlbum(Request $request)
    {
        $albumList = Gallery::select('id', 'name')
            ->whereType(Gallery::TYPE_ALBUM)
            ->get();

        return $this->jsonSuccess('', [
            'data' => $albumList,
        ]);
    }
}
