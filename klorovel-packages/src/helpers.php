<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

//  Patch $_SERVER agar bisa diakses dari subfolder dan /public nya hilang
$_SERVER['SCRIPT_NAME'] = str_replace('/public', '', $_SERVER['SCRIPT_NAME']);

//  KLOROVER CORE
if (!function_exists('selected_if')) {
    function selected_if($cek)
    {
        return $cek ? 'selected' : '';
    }
}

if (!function_exists('checked_if')) {
    function checked_if($cek)
    {
        return $cek ? 'checked' : '';
    }
}

if (!function_exists('required_if')) {
    function required_if($cek)
    {
        return $cek ? 'required' : '';
    }
}

if (!function_exists('copyright_year')) {
    function copyright_year($tahun = null)
    {
        if (!$tahun) $tahun = date('Y');
        $tahunSekarang = date('Y');
        return ($tahun == $tahunSekarang) ? $tahunSekarang : $tahun . ' - ' . $tahunSekarang;
    }
}

if (!function_exists('random_number')) {
    function random_number($panjang)
    {
        $angka = '';
        for ($i = 0; $i < $panjang; $i++) {
            $angka .= (string) random_int(0, 9);
        }

        return $angka;
    }
}

if (!function_exists('short_number')) {
    function short_number($number, $precision = 2)
    {
        $divisors = array(
            pow(1000, 0) => '',
            pow(1000, 1) => 'K',
            pow(1000, 2) => 'M',
            pow(1000, 3) => 'B',
            pow(1000, 4) => 'T',
            pow(1000, 5) => 'Qa',
            pow(1000, 6) => 'Qi',
        );

        foreach ($divisors as $divisor => $shorthand) {
            if (abs($number) < ($divisor * 1000))
                break;
        }

        $num_out = number_format($number / $divisor, $precision);

        if ($precision > 0) {
            $dotzero = '.' . str_repeat('0', $precision);
            $num_out = str_replace($dotzero, '', $num_out);
        }
        return $num_out . $shorthand;
    }
}

if (!function_exists('array_to_config_string')) {
    function array_to_config_string($data)
    {
        $isi = var_export($data, true);
        $isi = preg_replace("/^([ ]*)(.*)/m", '$1$1$2', $isi);
        $array = preg_split("/\r\n|\n|\r/", $isi);
        $array = preg_replace(["/\s*array\s\($/", "/\)(,)?$/", "/\s=>\s$/"], [NULL, ']$1', ' => ['], $array);
        $isi = join(PHP_EOL, array_filter(["["] + $array));
        return "<?php\nreturn " . $isi . ';';
    }
}

if (!function_exists('is_local_domain')) {
    function is_local_domain()
    {
        return str_replace("www.", "", $_SERVER['HTTP_HOST']) != config('app.domain');
    }
}

if (!function_exists('macro_fullsql')) {
    function macro_fullsql($me)
    {
        /** @var \Illuminate\Eloquent\Query\Builder $me */
        $sql = str_replace(['%', '?'], ['%%', '%s'], $me->toSql());

        $handledBindings = array_map(function ($binding) {
            if (is_numeric($binding)) {
                return $binding;
            }

            $value = str_replace(['\\', "'"], ['\\\\', "\'"], $binding);

            return "'{$value}'";
        }, $me->getConnection()->prepareBindings($me->getBindings()));

        $fullSql = vsprintf($sql, $handledBindings);
        return $fullSql;
    }
}

//  FILE HELPER
if (!function_exists('delete_if_exists')) {
    function delete_if_exists($file)
    {
        if (isset($file) && $file && File::exists($file)) {
            File::delete($file);
        }
    }
}

if (!function_exists('try_delete_if_exists')) {
    function try_delete_if_exists($file)
    {
        try {
            if (isset($file) && $file && File::exists($file)) {
                File::delete($file);
            }
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
}

if (!function_exists('generate_filename')) {
    function generate_filename($ext, $nama = null, $withTime = true)
    {
        $hasil = '';

        if ($ext instanceof \Illuminate\Http\UploadedFile) {
            $ext = $ext->getClientOriginalExtension();
        }

        //  Remove dot in begin
        if (Str::startsWith($ext, ".")) {
            $ext = substr($ext, 1);
        }

        if (!$nama) {
            $nama = Str::random(28);
        }

        //  append current time
        if ($withTime) {
            $nama .= '_' . time();
        }

        //  Add extension
        $hasil = Str::slug($nama, '_') . '.' . $ext;

        return $hasil;
    }
}

if (!function_exists('slug_with_random_number')) {
    function slug_with_random_number($s, $randomLength = 5)
    {
        return Str::slug($s . '-' . random_number($randomLength));
    }
}

//  AVATAR HELPER
if (!function_exists('get_avatar_by_file')) {
    function get_avatar_by_file($file, $default = null)
    {
        if (isset($file) && !empty($file)) {
            if (Str::startsWith($file, 'http')) {
                return $file;
            } else if (File::exists('uploads/avatar/' . $file)) {
                return url('uploads/avatar/' . $file);
            }
        }

        if ($default) {
            return $default;
        }

        return url('uploads/avatar/default.png');
    }
}

//  DATE
//  TODO merge logic with year, month, day as param
if (!function_exists('carbon_range_year')) {
    function carbon_range_year($mulai, $selesai)
    {
        if ($mulai->isSameYear($selesai)) {
            $kata = $selesai->isoFormat('YYYY');
        } else {
            $kata = $mulai->isoFormat('YYYY') . ' - ' . $selesai->isoFormat('YYYY');
        }

        return $kata;
    }
}

if (!function_exists('carbon_range_text')) {
    function carbon_range_text($begin, $end, $withTime = false)
    {
        if (! $withTime) {
            if ($begin->isSameDay($end)) {
                $kata = $end->isoFormat('DD MMMM YYYY');
            } else if ($begin->isSameMonth($end)) {
                $kata = $begin->isoFormat('DD') . ' - ' . $end->isoFormat('DD MMMM YYYY');
            } else if ($begin->isSameYear($end)) {
                $kata = $begin->isoFormat('DD MMMM') . ' - ' . $end->isoFormat('DD MMMM YYYY');
            } else {
                $kata = $begin->isoFormat('DD MMMM YYYY') . ' - ' . $end->isoFormat('DD MMMM YYYY');
            }
        } else {
            if ($begin->isSameDay($end)) {
                $kata = $begin->isoformat('DD MMMM YYYY (HH:mm') . ' - ' . $end->isoformat('HH:mm)');
            } else {
                $kata = $begin->isoformat('DD MMMM YYYY HH:mm') . ' - ' . $end->isoformat('DD MMMM YYYY HH:mm');
            }
        }

        return $kata;
    }
}

//  UPLOAD PATH
if (!function_exists('encode_local_upload')) {
    function encode_local_upload($isi)
    {
        $regexList = [
            '/' . preg_replace('/\//', '\\\\/', url('uploads/media')) . '/',
        ];

        $replaceList = [
            '@baseupload::',
        ];

        $isi = preg_replace(
            $regexList,
            $replaceList,
            $isi
        );

        return $isi;
    }
}

if (!function_exists('decode_local_upload')) {
    function decode_local_upload($isi)
    {
        $regexnya = '/@baseupload::/';
        $isi = preg_replace(
            $regexnya,
            url('uploads/media'),
            $isi
        );
        return $isi;
    }
}

if (!function_exists('info_paginate')) {
    function info_paginate($data, $type, $isFiltered = false)
    {
        if (!isset($data)) {
            return "";
        }

        try {
            $ret = "Menampilkan";
            $pageSekarang = $data->currentPage();
            $dataTotal = $data->total();
            $dataJumlah = $data->count();
            $dataPerPage = $data->perPage();

            $dataPosisi = ($pageSekarang - 1) * $dataPerPage;
            $ret .= ' <span class="font-weight-600">' . (($dataTotal == 0) ? 0 : $dataPosisi + 1) . '</span>';
            $ret .= ' &minus;';
            $ret .= ' <span class="font-weight-600">' . ($dataPosisi + $dataJumlah) . '</span>';
            $ret .= ' dari <span class="font-weight-600">' . $dataTotal . '</span>';
            $ret .= ' ' . $type;

            if ($isFiltered) {
                $ret .= " Terfilter";
            }

            return $ret;
        } catch (\Throwable $th) {
            return "";
        }
    }
}
