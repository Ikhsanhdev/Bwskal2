<?php

namespace AyatKyo\Klorovel\Core\Services;

class KlorovelToken
{
    protected $keyHash = 'app::make-token';
    protected $keyToken = 'app::klorovel::token';
    protected $keyHeader = 'app::klorovel::head';

    public function make($id = 0, $lama = 8)
    {
        //  Ambil timestamp
        $c_sekarang = now();
        $c_expired = now()->addHours($lama);
        $ts_expired = $c_expired->timestamp;

        //  Isi Hashed
        $hashed = KlorovelEncryption::encrypt((string)$ts_expired . '::' . (string)$id, $this->keyHash);

        //  Raw Token
        $token = KlorovelEncryption::encrypt($hashed, $this->keyToken . '::' . md5(config('app.key')));

        //  Enkripsi timestamp
        $ts_encrypt = KlorovelEncryption::encrypt($ts_expired, base64_decode($token));

        //  Panjang panjang
        $panjang_token = strlen($token);
        $setengah_token = (int)$panjang_token / 2;
        $panjang_timestamp = strlen($ts_encrypt);

        //  Buat header
        $token_header = (string)$panjang_token . '::' . (string)$panjang_timestamp;
        $header_encrypt = KlorovelEncryption::encrypt($token_header, $this->keyHeader);

        //  Token gasan app
        $token_n_ts = substr($token, 0, $setengah_token) . $ts_encrypt . substr($token, $setengah_token);
        $public_token = $header_encrypt . '.' . $token_n_ts;

        //  Return semua
        return (object) array(
            'token' => $token,
            'timestamp' => $ts_expired,
            'timestamp_encrypt' => $ts_encrypt,
            'header' => $token_header,
            'header_encrypt' => $header_encrypt,
            'token_stamped' => $token_n_ts,
            'public_token' => $public_token
        );
    }

    public function parse($token_stamped)
    {
        try {
            //  Bila ada header nya otomatis ambil
            if (strpos($token_stamped, ".")) {
                //  Ambil panjang dari header
                $pecah_token = explode('.', $token_stamped);
                $header_encrypt = $pecah_token[0];
                $token_stamped = $pecah_token[1];

                $token_header = KlorovelEncryption::decrypt($header_encrypt, $this->keyHeader);
                $e_token_header = explode('::', $token_header);
                $panjang_token = (int)$e_token_header[0];
                $panjang_timestamp = (int)$e_token_header[1];
            } else {
                $panjang_token = 88;
                $panjang_timestamp = 32;
            }

            //  Panjang panjang
            $setengah_token = (int)$panjang_token / 2;

            //  Ambil token dan timestamp
            $token = substr($token_stamped, 0, $setengah_token) . substr($token_stamped, $setengah_token + $panjang_timestamp);
            $ts_encrypt = substr($token_stamped, $setengah_token, $panjang_timestamp);

            $ts_expired = (int)KlorovelEncryption::decrypt($ts_encrypt, base64_decode($token));

            //  is expired ?
            $c_sekarang = now();
            $is_expired = $ts_expired <= $c_sekarang->timestamp;

            //  Token gasan app
            $token_n_ts = substr($token, 0, $setengah_token) . $ts_encrypt . substr($token, $setengah_token);
            $public_token = $header_encrypt . '.' . $token_n_ts;

            return (object) array(
                'token' => $token,
                'timestamp' => $ts_expired,
                'timestamp_encrypt' => $ts_encrypt,
                'token_stamped' => $token_stamped,
                'header' => $token_header,
                'header_encrypt' => $header_encrypt,
                'expired' => $is_expired,
                'token_stamped' => $token_n_ts,
                'public_token' => $public_token
            );
        } catch (\Exception $e) {
            throw new \Exception("Invalid Token");
        }
    }

    //  Validasi
    public function isValid($token)
    {
        try {
            $parsed = $this->parse($token);
            if ($parsed->expired) return false;
        } catch (\Exception $e) {
            return false;
        }
        return $parsed;
    }
}
