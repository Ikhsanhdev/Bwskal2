<?php

namespace AyatKyo\Klorovel\Core\Services;

/**
 *  TODO:
 *  - make encrypt decrypt configurable and delete encrypt2 decrypt2 method
 */

class KlorovelEncryption
{
    public static $method = 'AES-256-CBC';

    public static function encrypt($string, $acak = '')
    {
        $key = hash('sha256', config('app.key'));
        $iv = substr(hash('sha256', md5($key . $acak)), 0, 16);

        $hasil = openssl_encrypt($string, static::$method, $key, 0, $iv);

        if ($hasil === false) {
            throw new \Exception('Gagal melakukan encrypt');
        }

        return base64_encode($hasil);
    }

    public static function decrypt($string, $acak = '')
    {
        $key = hash('sha256', config('app.key'));
        $iv = substr(hash('sha256', md5($key . $acak)), 0, 16);

        $hasil = openssl_decrypt(base64_decode($string), static::$method, $key, 0, $iv);

        if ($hasil === false) {
            throw new \Exception('Gagal melakukan decrypt');
        }

        return $hasil;
    }

    public static function encrypt2($string, $opt = [])
    {
        $key = hash('sha256', config('app.key'));
        $iv = substr(hash('sha256', md5($key . $opt['acak'])), 0, $opt['iv']);

        $hasil = openssl_encrypt($string, $opt['method'], $key, 0, $iv);

        if ($hasil === false) {
            throw new \Exception('Gagal melakukan encrypt');
        }

        if (isset($opt['b64']) && $opt['b64']) {
            return base64_encode($hasil);
        } else {
            return $hasil;
        }
    }

    public static function decrypt2($string, $opt = [])
    {
        $key = hash('sha256', config('app.key'));
        $iv = substr(hash('sha256', md5($key . $opt['acak'])), 0, $opt['iv']);

        $hasil = openssl_decrypt(isset($opt['b64']) && $opt['b64'] ? base64_decode($string) : $string, $opt['method'], $key, 0, $iv);

        if ($hasil === false) {
            throw new \Exception('Gagal melakukan decrypt');
        }

        return $hasil;
    }

    public function randomNumber($length = 0)
    {
        $awal = (int) str_pad(1, $length, '0');
        $akhir = (int) str_pad(9, $length, '9');
        return (string) mt_rand($awal, $akhir);
    }
}
