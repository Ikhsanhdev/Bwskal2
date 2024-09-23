<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use AyatKyo\Klorovel\Core\Facades\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MedsosAuthController extends Controller
{
    public function ig(Request $request)
    {
        try {
            //  TODO handle error
                
            //  Get short lived token
            $shortRes = Http::asForm()->post('https://api.instagram.com/oauth/access_token', [
                'client_id'     => config('medsos-feed.instagram.app_id'),
                'client_secret' => config('medsos-feed.instagram.app_secret'),
                'grant_type'    => 'authorization_code',
                'redirect_uri'  => route('medsos-feed-callback.ig'),
                'code'          => $request->get('code'),
            ])->json();

            if (! isset($shortRes['access_token'])) {
                throw new \Exception("Gagal mengambil 'short lived token'" . (isset($shortRes['error_message']) ? ': ' . $shortRes['error_message'] : ''));
            }

            $shortToken = $shortRes['access_token'];

            //  Get long lived token
            $longTokenEndpoint = 'https://graph.instagram.com/access_token?grant_type=ig_exchange_token&client_secret=' . config('medsos-feed.instagram.app_secret') . '&access_token=' . $shortToken;
            $longRes = Http::get($longTokenEndpoint)->json();

            if (! isset($longRes['access_token'])) {
                throw new \Exception("Gagal mengambil 'long lived token'" . (isset($longRes['error_message']) ? ': ' . $longRes['error_message'] : ''));
            }

            $longToken = $longRes['access_token'];

            //  Save token
            $medsosFeedSetting = Setting::loadOrCreateFromDb('medsos-feed');
            $medsosFeedSetting->ig_token = $longToken;
            $medsosFeedSetting->ig_token_expire = now()->addSeconds($longRes['expires_in'])->getTimestamp();
            if (!Setting::save('medsos-feed', $medsosFeedSetting, true)) {
                throw new \Exception("Gagal menyimpan access_token");
            }
        } catch (\Throwable $th) {
            throw $th;
        }

        //  Redirect to medsos setting
        return redirect()->route('admin.medsos-feed.index');
    }
}
