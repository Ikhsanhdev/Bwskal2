<?php

namespace AyatKyo\Klorovel\Core\Services;

use Illuminate\Support\Facades\File;
use AyatKyo\Klorovel\Core\Models\Setting as ModelsSetting;
use AyatKyo\Klorovel\Core\Support\KlorovelCollection;

class Setting
{
    protected $data;
    protected $path;

    public function __construct()
    {
        $this->data = new KlorovelCollection();
        $this->path = resource_path('settings');
    }

    public function autoload()
    {
        //  Load setting yang ada di resources
        foreach (glob($this->path . DIRECTORY_SEPARATOR . "*.php") as $settingFile) {
            //  Ambil nama sebagai key
            $settingName = basename($settingFile, '.php');
            //  Baca isi nya
            $settingIsi = require $settingFile;
            //  Tambah setting
            $this->data->put($settingName, new KlorovelCollection($settingIsi));
        }

        return $this->data;
    }

    //  Cache setting untuk 'key' ke file
    public function cache($key) {
        if (! File::exists($this->path)) {
            File::makeDirectory($this->path, 0755, true);
        }
        if ($data = $this->get($key)) {
            return File::put($this->path . DIRECTORY_SEPARATOR . $key . '.php', '<?php
return ' . var_export($data->toArray(), true) .';');
        }
    }
    
    //  Menyimpan setting yang ada ke database
    public function save($key, $arr = null, $autoload = null) {
        //  cek apakah ada key nya
        if ($this->has($key)) {
            //  Ambil dulu
            $setting = ModelsSetting::where('name', $key)->first();

            //  Bila tidak ada buat baru
            if (!$setting) {
                $setting = new ModelsSetting;
                $setting->name = $key;
            }
            //  Update value
            $setting->value = ($arr !== null) ? $arr : $this->get($key);
            if ($autoload !== null) {
                $setting->autoload = $autoload;
            }

            if ($setting->autoload) {
                $this->cache($key);
            }
            return $setting->save();
        }
    }

    public function loadFromJsonString($key, $data) {
        $this->data->put($key, new KlorovelCollection(json_decode($data)));
        return $this->data->get($key);
    }

    public function loadFromDb($key)
    {
        $setting = ModelsSetting::where('name', $key)->first();
        if ($setting === null)
            return null;
            
        $this->data->put($key, new KlorovelCollection($setting->value));
        $data = $this->data->get($key);
        return $data;
    }

    public function loadOrCreateFromDb($key) {
        $setting = $this->loadFromDb($key);

        if ($setting === null) {
            $setting = new ModelsSetting;
            $setting->name = $key;
            $setting->value = new KlorovelCollection;

            //  Put
            $this->data->put($key, new KlorovelCollection($setting->value));
        }

        $data = $this->data->get($key);
        return $data;
    }

    public function data() {
        return $this->data;
    }

    public function get($key)
    {
        $arrKey = explode('.', $key);
        $keyItem = array_shift($arrKey);
        $keyValue = join('.', $arrKey);

        //  Ambil langsung key nya
        if ($keyValue == null) {
            if (! $this->data->has($keyItem)) {
                return null;
            }
            return $this->data->get($keyItem);
        } elseif ($this->has($keyItem)) {
            return $this->data->get($keyItem)[$keyValue] ?? null;
        } else {
            return null;
        }
    }

    public function set($stringkey, $value) {
        //  Cek apakah ada
        $arrKey = explode('.', $stringkey);
        $keyItem = array_shift($arrKey);
        $keyValue = join('.', $arrKey);
        
        //  Jika keyvalue nya null, berarti langsung set isi dari key
        if ($keyValue == null) {
            //  Set langsung ke key
            $this->data->put($keyItem, ($value instanceof KlorovelCollection) ? $value : new KlorovelCollection($value));
        } elseif ($this->has($keyItem)) {
            //  Set ke isi dari key
            $this->data[$keyItem][$keyValue] = $value;
        } else {
            return null;
        }

        return $this;
    }

    public function has($key) {
        return $this->data->has($key);
    }
}