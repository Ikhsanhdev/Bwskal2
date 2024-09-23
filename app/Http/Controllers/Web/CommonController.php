<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use App\Models\Announcement;
use App\Models\Faq;
use App\Models\Gallery;
use App\Models\Infografis;
use App\Models\LinkTerkait;
use App\Models\Page;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Slide;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommonController extends Controller
{
    public $viewPath = 'web.';

    public function index(Request $request)
    {
        //  Post
        $beritaList = Post::select([
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
            ->where(PostCategory::table('slug'), '!=', PostCategory::DITJEN_SDA_SLUG)
            ->where(Post::table('status'), Post::STATUS_PUBLISH)
            ->limit(4)
            ->orderBy('created_at', 'DESC')
            ->get();
        $beritaUtama = $beritaList->shift();

        //  Berita DitjenSDA
        $beritaDitjenSDA = Post::select([
            Post::table('title'),
            Post::table('slug'),
            Post::table('created_at'),
            Post::table('cover'),
            ])
            ->joinCategory()
            ->where(PostCategory::table('slug'), '=', PostCategory::DITJEN_SDA_SLUG)
            ->where(Post::table('status'), Post::STATUS_PUBLISH)
            ->limit(3)
            ->orderBy('created_at', 'DESC')
            ->get();

        //  Slide
        $slides = Slide::select([
            Slide::table('id'),
            Slide::table('type'),
            DB::raw("COALESCE(" . Post::table('title') . ", " . Slide::table("title") . ") as title"),
            DB::raw("IF(" . Slide::table('type') . " = 'image', " . Slide::table("value") . ", " . Post::table("cover") . ") as value"),
            DB::raw("IF(" . Slide::table('type') . " = 'image', " . Slide::table("created_at") . ", " . Post::table("created_at") . ") as created_at"),
            Slide::table('link'),
            Slide::table('show_title'),
            Post::table('slug'),
            Post::table('hit_total as post_hit'),
            PostCategory::table('slug as category_slug'),
            PostCategory::table('name as category_name'),
            User::table('fullname as author'),
        ])
            ->leftJoin(Post::table(), function ($j) {
                $j->on(Slide::table('value'), '=', Post::table('id'))
                    ->where(Slide::table('type'), 'post')
                    ->where(Post::table('status'), Post::STATUS_PUBLISH);
            })
            ->leftJoin(PostCategory::table(), function ($j) {
                $j->on(Post::table('category_id'), '=', PostCategory::table('id'))
                    ->where(Slide::table('type'), 'post');
            })
            ->leftJoin(User::table(), function ($j) {
                $j->on(User::table('id'), '=', Post::table('user_id'))
                    ->where(Slide::table('type'), 'post');
            })
            ->havingRaw('created_at IS NOT NULL')
            ->orderByRaw('-' . Slide::table('featured_position') . ' DESC')
            ->orderBy(Slide::table('created_at'), 'DESC')
            ->get();

        //  Pengumuman
        $announcements = Announcement::select([
            Announcement::table('title'),
            Announcement::table('slug'),
            Announcement::table('cover'),
            Announcement::table('hit'),
            Announcement::table('created_at'),
        ])
            ->whereRaw('NOW() >= active_from')
            ->orderBy('active_from', 'DESC')
            ->limit(4)
            ->get();

        //  Infografis
        $infografisList = Infografis::limit(5)->latest()->get();

        //  Gallery
        $galleryFoto = Gallery::whereType(Gallery::TYPE_IMAGE)
            ->orderBy('created_at', 'DESC')
            ->limit(6)
            ->get();
        $galleryFotoHasMore = $galleryFoto->count() > 5;
        $galleryFoto = $galleryFoto->take(5);

        $galleryVideo = Gallery::whereType(Gallery::TYPE_VIDEO)
            ->orderBy('created_at', 'DESC')
            ->limit(6)
            ->get();
        $galleryVideoHasMore = $galleryVideo->count() > 5;
        $galleryVideo = $galleryVideo->take(5);

        $linkTerkaitList = LinkTerkait::orderBy('position', 'asc')
            ->limit(6)
            ->get();

        $agendaList = Agenda::select([
            'title',
            'slug',
            'begin_at',
            DB::raw('NOW() BETWEEN begin_at AND end_at as is_active')
        ])
            ->limit(4)
            ->orderBy('created_at', 'desc')
            ->get();

        return $this->view('index', [
            'beritaList'          => $beritaList,
            'beritaUtama'         => $beritaUtama,
            'beritaDitjenSDA'     => $beritaDitjenSDA,
            'slides'              => $slides,
            'announcements'       => $announcements,
            'infografisList'      => $infografisList,
            'galleryFoto'         => $galleryFoto,
            'galleryFotoHasMore'  => $galleryFotoHasMore,
            'galleryVideo'        => $galleryVideo,
            'galleryVideoHasMore' => $galleryVideoHasMore,
            'linkTerkaitList'     => $linkTerkaitList,
            'agendaList'          => $agendaList,
        ]);
    }

    public function agenda(Request $request)
    {
        $list = Agenda::orderBy('begin_at', 'DESC')->get();

        return $this->view('agenda', compact('list'));
    }

    public function faq(Request $request)
    {
        $faqs = Faq::whereIsShow(true)
            ->orderBy('position', 'asc')
            ->get();

        $lastUpdate = null;
        if (count($faqs)) {
            $lastUpdate = $faqs->sortByDesc('updated_at')->first()->updated_at->isoFormat('DD MMMM YYYY');
        }

        return $this->view('faq', compact('faqs', 'lastUpdate'));
    }

    public function getPage(Request $request, $slug)
    {
        $page = Page::whereSlug($slug)
            ->where(function ($q) {
                $q->getModel()->timestamps = false;
            });
        $page->increment('hit');
        $page = $page->first();
        if (!$page) {
            return abort(404);
        }

        return $this->view('halaman', [
            'data' => $page,
        ]);
    }

    public function search(Request $request)
    {
        //  Redirect to homepage
        if (!$request->query('q')) {
            return redirect()->route('web.index');
        }

        $katacari = $request->query('q');
        $ftKata = "MATCH(title) AGAINST('" . $katacari . "' IN NATURAL LANGUAGE MODE)";

        $list = Post::select([
            'id',
            'slug',
            'title',
            'content',
            'created_at',
            DB::raw($ftKata . ' as skor'),
            ])
            ->having('skor', '>', 0)
            ->whereIsActive(true)
            ->where(Post::table('status'), Post::STATUS_PUBLISH)
            ->orderBy('skor', 'desc')
            ->paginate(25);

        return $this->view('pencarian', [
            'list' => $list,
        ]);
    }
}
