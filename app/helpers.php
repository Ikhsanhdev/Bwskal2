<?php

use Illuminate\Support\Carbon;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

if (!function_exists('tanggal_indo')) {
    function tanggal_indo($tanggal)
    {
        if (is_string($tanggal)) {
            $tanggal = Carbon::createFromFormat('Y-m-d', $tanggal);
        }
        return $tanggal->isoFormat('DD MMMM YYYY');
    }
}

if (!function_exists('hitung_usia')) {
    function hitung_usia($tanggal)
    {
        if (is_string($tanggal)) {
            $tanggal = Carbon::createFromFormat('Y-m-d', $tanggal);
        }
        
        return $tanggal->age;
    }
}

if (!function_exists('status_badge_list')) {
    function status_badge_list()
    {
        return [
            'draft' => [
                'text'  => 'Draft',
                'class' => 'badge-secondary text-white',
            ],
            'pending' => [
                'text'  => 'Menunggu',
                'class' => 'badge-warning text-white',
            ],
            'banned' => [
                'text'  => 'Dibanned',
                'class' => 'badge-danger text-white',
            ],
            'inactive' => [
                'text'  => 'Non-Aktif',
                'class' => 'badge-danger text-white',
            ],
            'reject' => [
                'text'  => 'Ditolak',
                'class' => 'badge-danger text-white',
            ],
            'approve' => [
                'text'  => 'Disetujui',
                'class' => 'badge-success',
            ],
            'active' => [
                'text'  => 'Aktif',
                'class' => 'badge-success',
            ],
            'done' => [
                'text'  => 'Selesai',
                'class' => 'badge-success',
            ],
        ];
    }
}

if (! function_exists('get_kelamin_text')) {
    function get_kelamin_text($huruf)
    {
        return $huruf === 'l' ? 'Laki-laki' : 'Perempuan';
    }
}

if (! function_exists('public_upload_file_rules')) {
    function public_upload_file_rules()
    {
        return 'application/pdf,image/bmp,image/gif,image/jpeg,image/png';
    }
}

if (! function_exists('public_upload_file_message')) {
    function public_upload_file_message()
    {
        return 'Berkas harus berupa pdf atau gambar';
    }
}

if (! function_exists('phone_normalize')) {
    function phone_normalize($phone)
    {
        return preg_replace('/(?:\+62|0)?(\d+)/', '$1', $phone);
    }
}

//  Menu builder
if (!function_exists('parse_href')) {
    function parse_href($isi)
    {
        if (Str::startsWith($isi, 'http://') || Str::startsWith($isi, 'https://')) {
            return $isi;
        }
        if ($isi == "@beranda") {
            $isi = "";
        }
        //  Route Handler
        if (preg_match('/\@route\[(?<route>.*)\]/', $isi, $isiRoute)) {
            return new HtmlString('{{ route(\'' . $isiRoute['route'] . '\') }}');
        }
        //  RouteGroup
        if (preg_match('/(?<grup>.*)\[(?<link>.*)\]/', $isi, $isiRoute)) {
            switch ($isiRoute['grup']) {
                case "web":
                    return new HtmlString('{{ url(\'' . $isiRoute['link'] . '\') }}');
                    break;
            }
        }
        return new HtmlString('{{ url(\'' . $isi . '\') }}');
    }
}
if (!function_exists('parse_target')) {
    function parse_target($menu)
    {
        if (isset($menu->target)) {
            return $menu->target;
        }
        $isi = null;
        if (property_exists($menu, 'data') && ($menu->type == 'link' || $menu->type == 'default' || $menu->type == 'halaman')) {
            $isi = $menu->data;
        }
        if ($isi) {
            if (Str::startsWith($isi, 'http://') || Str::startsWith($isi, 'https://')) {
                return '_blank';
            }
        }
        return '_self';
    }
}

if (! function_exists('make_post_link')) {
    function make_post_link($post) {
        return url($post->created_at->format('Y/m/') . $post->slug);
    }
}

if (! function_exists('make_footer_kontak_item')) {
    function make_footer_kontak_item($item) {
        $item->type = $item->type ?? null;
        $ret = '<span class="fw-700">' . $item->value . '</span>';

        switch ($item->type) {
            case 'phone':
                $ret = '<a class="text-white fw-700" href="tel:' . normalize_phone($item->value) . '">' . $item->value . '</a>';
                break;
            case 'link':
                $ret = '<a class="text-white fw-700" href="' . $item->value . '">' . $item->value . '</a>';
                break;
            case 'email':
                $ret = '<a class="text-white fw-700" href="mailto:' . $item->value . '">' . $item->value . '</a>';
                break;
        }
        
        return new HtmlString($ret);
    }
}

if (! function_exists('normalize_phone')) {
    function normalize_phone($str) {
        return preg_replace("/^(0|\+?62)/", "+62", preg_replace("/[^\d]/", "", $str));
    }
}

if (! function_exists('phone_normalize')) {
    function phone_normalize($phone)
    {
        return preg_replace('/(?:\+62|0)?(\d+)/', '$1', $phone);
    }
}

if (!function_exists('flaticon_from_mime')) {
    function flaticon_from_mime($mime)
    {
        switch ($mime) {
            case 'application/pdf':
                return 'flaticon-pdf';
            break;
            case 'application/vnd.ms-powerpoint':
            case 'application/vnd.openxmlformats-officedocument.presentationml.presentation':
                return 'flaticon-ppt';
            break;
            case 'application/msword':
            case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
                return 'flaticon-doc';
            break;
            case 'application/vnd.ms-excel':
            case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
                return 'flaticon-xls';
            break;
            case 'application/zip':
                return 'flaticon-zip';
            break;
            default:
                return 'flaticon-file';
            break;
        }
    }
}

if (!function_exists('get_medsos_icon')) {
    function get_medsos_icon($tipe)
    {
        switch ($tipe) {
            default:
                return "mdi-" . $tipe;
            break;
        }
    }
}
