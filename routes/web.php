<?php

use Illuminate\Support\Facades\Route;

$proxy_url = getenv('PROXY_URL');
$proxy_schema = getenv('PROXY_SCHEMA');

if (!empty($proxy_url)) {
    URL::forceRootUrl($proxy_url);
}

if (!empty($proxy_schema)) {
    URL::forceScheme($proxy_schema);
}


//  ADMIN
Route::prefix('admin')
    ->name('admin.')
    ->middleware('auth.role:supermin,admin')
    ->group(function () {
        $pageCtrl = App\Http\Controllers\Admin\CommonController::class;
        Route::redirect('/', 'admin/dasbor');

        Route::get('dasbor', [$pageCtrl, 'dasbor'])->name('dasbor.index');

        Route::KlorovelResource('page', App\Http\Controllers\Admin\PageController::class, [
            'modal' => false,
        ])
            ->middleware('auth.role:supermin,admin');
        Route::KlorovelResource('post', App\Http\Controllers\Admin\PostController::class, [
            'modal' => false,
        ]);
        Route::KlorovelResource('post-category', App\Http\Controllers\Admin\PostCategoryController::class);
        Route::KlorovelResource('slide', App\Http\Controllers\Admin\SlideController::class)
            ->post('post-list')
            ->middleware('auth.role:supermin,admin');

        Route::prefix('peta')->name('peta.')
            ->controller(App\Http\Controllers\Admin\PetaController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::put('/', 'update')->name('update');
            });

        Route::KlorovelResource('announcement', App\Http\Controllers\Admin\AnnouncementController::class, [
            'modal' => false,
        ]);
        Route::KlorovelResource('agenda', App\Http\Controllers\Admin\AgendaController::class);

        //  Gallery
        Route::prefix('gallery')->name('gallery.')
            ->controller(\App\Http\Controllers\Admin\GalleryController::class)
            ->group(function () {
                Route::get('/', "index")->name('index');
                Route::get('{album_id}', "getAlbum")
                    ->where([
                        'album_id' => '[0-9]+'
                    ])
                    ->name('album');
                Route::post('datatable', "datatable")->name('datatable');
                Route::get('tambah', "create")->name('create');
                Route::post('ubah', "edit")->name('edit');
                Route::post('/', "store")->name('store');
                Route::put('/', "update")->name('update');
                Route::delete('/', "destroy")->name('destroy');
                Route::get('album-list', "listAlbum")->name('list-album');
            });
        
        Route::KlorovelResource('pegawai', App\Http\Controllers\Admin\PegawaiController::class)
            ->put('order');

        Route::KlorovelResource('poster', App\Http\Controllers\Admin\InfografisController::class);
        Route::KlorovelResource('link-terkait', App\Http\Controllers\Admin\LinkTerkaitController::class)
            ->put('order');
        
        //  Media social feed
        Route::prefix('medsos-feed')->name('medsos-feed.')
            ->controller(App\Http\Controllers\Admin\MedsosFeedController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::put('/', 'update')->name('update');
                Route::post('refresh-ig', 'refreshIg')->name('refresh-ig');
            });

        Route::prefix('kontak-wa')->name('kontak-wa.')
            ->controller(App\Http\Controllers\Admin\KontakWaController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::put('/', 'update')->name('update');
            });
            
        // Route::KlorovelResource('kontak-form', App\Http\Controllers\Admin\KontakFormController::class);

        //  Unduhan
        Route::KlorovelResource('unduhan', App\Http\Controllers\Admin\UnduhanController::class);
        Route::KlorovelResource('unduhan/kategori', App\Http\Controllers\Admin\UnduhanKategoriController::class);
        Route::prefix('unduhan/request')
            ->name('unduhan.request.')
            ->controller(\App\Http\Controllers\Admin\UnduhanRequestController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('datatable', 'datatable')->name('datatable');
                Route::post('detail', 'detail')->name('detail');
                Route::post('verify', 'verify')->name('verify');
            });

        //  FAQ
        Route::KlorovelResource('faq', App\Http\Controllers\Admin\FaqController::class)
            ->put('order');

        Route::KlorovelResource('user', App\Http\Controllers\Admin\UserController::class)
            ->post('detail')
            ->middleware('auth.role:supermin,admin');

        //  Menu
        Route::prefix('menu')->name('menu.')
            ->middleware('auth.role:supermin,admin')
            ->controller(\App\Http\Controllers\Admin\MenuController::class)
            ->group(function () {
                Route::get('/', "index")->name('index');
                Route::put('/', "update")->name('update');
                Route::get('halaman', "getHalaman")->name('get-halaman');
            });

        //  Pengaturan Situs
        Route::prefix('pengaturan-situs')->name('pengaturan-situs.')
            ->controller(App\Http\Controllers\Admin\PengaturanSitusController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('{page}', "getPage")->name('page');
                Route::put('{page}', "update")->name('update');
            });

        //  Pengaturan Akun
        Route::prefix('pengaturan-akun')->name('pengaturan-akun.')
            ->controller(App\Http\Controllers\Admin\PengaturanAkunController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::put('/', 'update')->name('update');
            });

        //  System Info
        Route::prefix('system-info')
            ->name('system-info.')
            ->controller(App\Http\Controllers\Admin\SystemInfoController::class)
            ->middleware('auth.role:supermin')
            ->group(function () {
                Route::get('/', 'index')->name('index');
            });
    });

Route::KlorovelAuth();

Route::get('lupa-sandi', [\App\Http\Controllers\Admin\LupaSandiController::class, 'index'])->name('lupa-sandi.index');
Route::post('lupa-sandi', [\App\Http\Controllers\Admin\LupaSandiController::class, 'store'])->name('lupa-sandi.store');
Route::get('reset-sandi/{token}', [\App\Http\Controllers\Admin\ResetSandiController::class, 'index'])->name('reset-sandi.index');
Route::put('reset-sandi/{token}', [\App\Http\Controllers\Admin\ResetSandiController::class, 'update'])->name('reset-sandi.update');

//  WEB
Route::controller(\App\Http\Controllers\Web\CommonController::class)
    ->name('web.')
    ->middleware('visitor.log')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('agenda', 'agenda')->name('agenda');
        Route::get('faq', 'faq')->name('faq');
        Route::get('pencarian', 'search')->name('pencarian');
    });

Route::controller(\App\Http\Controllers\Web\PegawaiController::class)
    ->prefix('pegawai')
    ->name('web.pegawai.')
    ->group(function () {
        Route::get('/', 'index')->middleware('visitor.log')->name('index');
        Route::post('detail', 'detail')->name('detail');
    });

// Route::controller(\App\Http\Controllers\Web\KontakController::class)
//     ->prefix('kontak')
//     ->name('web.kontak.')
//     ->group(function () {
//         Route::get('/', 'index')->middleware('visitor.log')->name('index');
//         Route::post('/', 'store')->name('store');
//     });

//  Berita
Route::controller(\App\Http\Controllers\Web\PostController::class)
    ->name('post.')
    ->middleware('visitor.log')
    ->group(function () {
        Route::get('berita', 'list')->name('index');
        Route::get('kategori/all', function () {
            return redirect()->route('post.index');
        });
        Route::get('kategori/{slug}', 'getCategory')
            ->where([
                'slug' => '^[a-z0-9]+(?:-[a-z0-9]+)*$',
            ])
            ->name('category');
        Route::get('{tahun}/{bulan}/{slug}', 'getDetail')
            ->where([
                'tahun' => '[0-9]{4}',
                'bulan' => '[0-9]{2}',
                'slug' => '^[a-z0-9]+(?:-[a-z0-9]+)*$',
            ])
            ->name('detail');
    });

Route::controller(\App\Http\Controllers\Web\AnnouncementController::class)
    ->prefix('pengumuman')
    ->name('pengumuman.')
    ->middleware('visitor.log')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('{slug}', 'getDetail')
            ->where([
                'slug' => '^[a-z0-9]+(?:-[a-z0-9]+)*$',
            ])
            ->name('detail');
    });
//  Galeri
Route::controller(\App\Http\Controllers\Web\GalleryController::class)
    ->prefix('gallery')
    ->name('gallery.')
    ->middleware('visitor.log')
    ->group(function () {
        Route::get('{type?}', "list")
            ->where('type', '^(video|image)$')
            ->name('index');
        Route::get('{slug}', "album")
            ->where('slug', '^[a-z0-9]+(?:-[a-z0-9]+)*$')
            ->name('album');
    });

Route::controller(\App\Http\Controllers\Web\DirektoriController::class)
    ->prefix('direktori')
    ->name('direktori.')
    ->middleware('visitor.log')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('{slug}/download', 'download')->name('download');
        Route::post('{slug}/request', 'request')->name('request');
    });

//  Instagram Callback
Route::get('medsos-feed-auth/ig', [\App\Http\Controllers\Web\MedsosAuthController::class, 'ig'])
    ->middleware('auth.role:supermin,admin')
    ->name('medsos-feed-callback.ig');

//  CKEDITOR
Route::post('/ckeditor-upload', [\App\Http\Controllers\Admin\CommonController::class, 'imageUpload'])->middleware('auth');

//  Halaman
Route::get('{slug}', [\App\Http\Controllers\Web\CommonController::class, 'getPage'])
    ->middleware('visitor.log')
    ->where([
        'slug' => '^[a-z0-9\x{00E0}-\x{00FC}_-]+',
    ])
    ->name('page');
