<?php

namespace App\Services;

use AyatKyo\Klorovel\Core\Facades\Setting;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class InstagramService
{
    public function getToken()
    {
        $token = Setting::get('medsos-feed.ig_token');
        if (! $token) {
            throw new \Exception('Access Token Instagram tidak ditemukan');
        }

        return $token;
    }

    public function getProfile()
    {
        $res = Http::get("https://graph.instagram.com/me?fields=account_type,id,media_count,username&access_token=" . $this->getToken());
        $res = json_decode(json_encode($res->json()));

        return $res;
    }

    public function getMedia($max = 6)
    {
        $res = Http::get("https://graph.instagram.com/me/media?fields=caption,id,media_type,media_url,permalink,thumbnail_url,timestamp,username,children{id,media_type,media_url,permalink,thumbnail_url,timestamp,username}&access_token=" . $this->getToken());
        $res = json_decode(json_encode($res->json()));

        $igData = [];
        foreach ($res->data as $item) {
            $data = [
                'id'        => $item->id,
                'caption'   => $item->caption,
                'type'      => $item->media_type,
                'link'      => $item->permalink,
                'timestamp' => $item->timestamp,
            ];
            
            $imageName = Str::slug($item->permalink) . '.jpg';

            //  Download image
            if (!File::exists(public_path("uploads/ig/$imageName"))) {
                Http::sink(public_path("uploads/ig/$imageName"))
                    ->get($item->thumbnail_url ?? $item->media_url);
            }

            $data['image'] = $imageName;
            $igData[] = (object) $data;

            //  Limit
            if (count($igData) >= $max) {
                break;
            }
        }

        //  Save data
        File::put(resource_path('json/ig-feed-raw.json'), json_encode($res));
        File::put(resource_path('json/ig-feed.json'), json_encode($igData));

        return $igData;
    }

    public function updateFeedTemplate($feedData)
    {
        $igFeedString = view('templates.ig-feed', [
            'username'   => $feedData['profile']->username,
            'mediaTotal' => $feedData['profile']->media_count,
            'list'       => $feedData['media'],
        ]);
        File::put(resource_path('views/components/web/ig-feed.blade.php'), $igFeedString);
    }
}
