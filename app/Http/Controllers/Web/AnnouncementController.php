<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\User;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public $viewPath = 'web.announcement.';

    public function index(Request $request)
    {
        $list = Announcement::select([
            Announcement::table('title'),
            Announcement::table('slug'),
            Announcement::table('created_at'),
            Announcement::table('hit'),
            Announcement::table('cover'),
            User::table('fullname as author'),
            ])
            ->joinUser()
            ->whereRaw('NOW() >= active_from')
            ->orderBy('active_from', 'DESC')
            ->paginate(10);

        return $this->view('index', [
            'list' => $list,
        ]);
    }

    public function getDetail(Request $request, $slug)
    {
        $pengumuman = Announcement::select([
            Announcement::table('id'),
            Announcement::table('title'),
            Announcement::table('slug'),
            Announcement::table('created_at'),
            Announcement::table('hit'),
            Announcement::table('cover'),
            Announcement::table('content'),
            User::table('fullname as author'),
        ])
        ->joinUser()
        ->whereSlug($slug)
        ->whereRaw('NOW() >= active_from');

        if (!($pengumuman = $pengumuman->first())) {
            return abort(404);
        }

        //  Update hit
        $pengumuman->timestamps = false;
        $pengumuman->increment('hit');
        $pengumuman->timestamps = true;

        return $this->view('detail', [
            'data' => $pengumuman,
        ]);
    }
}
