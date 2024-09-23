<?php

namespace App\Models;

use AyatKyo\Klorovel\Core\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Pegawai extends Model
{
    use HasFactory, ModelTrait;

    public $table = 'pegawai';
    
    const UPLOAD_PATH = 'uploads/pegawai/';

    public function getFotoImageAttribute()
    {
        $image = 'default.png';
        if ($this->image && File::exists(self::UPLOAD_PATH . $this->image)) {
            $image = $this->image;
        }
        
        return url(self::UPLOAD_PATH . $image);
    }

    public function getContentAttribute($value)
    {
        return decode_local_upload($value);
    }

    public function setContentAttribute($value)
    {
        $this->attributes['content'] = encode_local_upload($value);
    }
}
