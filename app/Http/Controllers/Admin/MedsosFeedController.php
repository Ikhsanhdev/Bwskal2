<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\InstagramService;
use AyatKyo\Klorovel\Core\Facades\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MedsosFeedController extends Controller
{
    public $viewPath = 'admin.medsos-feed.';

    public function index(Request $request)
    {
        $medsosFeedSetting = Setting::loadOrCreateFromDb('medsos-feed');

        $igLoginUrl = 'https://api.instagram.com/oauth/authorize?client_id=' . config('medsos-feed.instagram.app_id') . '&redirect_uri=' . urlencode(route('medsos-feed-callback.ig')) . '&scope=user_profile,user_media&response_type=code';

        return $this->view('index', [
            'data'       => $medsosFeedSetting,
            'igLoginUrl' => $igLoginUrl,
        ]);
    }

    public function update(Request $request)
    {
        $input = validator($request->all(), [
            'facebook'  => 'required',
            'twitter'   => 'required',
            // 'instagram' => 'required',
        ]);
        $this->responseFailsValidation($input);

        $medsosFeedSetting = Setting::loadOrCreateFromDb('medsos-feed');
        $medsosFeedSetting->facebook  = $request->facebook;
        $medsosFeedSetting->twitter   = $request->twitter;
        $medsosFeedSetting->instagram = $request->instagram;

        if (! Setting::save('medsos-feed', $medsosFeedSetting, true)) {
            return $this->jsonError('Gagal menyimpan pengaturan');
        }

        return $this->jsonSuccess('Berhasil menyimpan pengaturan', [
            'redir' => route('admin.medsos-feed.index'),
        ]);
    }

    public function refreshIg(Request $request, InstagramService $igService)
    {
        try {
            $profile = $igService->getProfile();
            $media = $igService->getMedia();

            $igService->updateFeedTemplate([
                'profile' => $profile,
                'media' => $media,
            ]);
        } catch (\Throwable $th) {
            return $this->jsonError([$th, $th->getMessage() ?? 'Refresh Feed gagal']);
        }

        return $this->jsonSuccess('Berhasil Refresh Feed');
    }
}
