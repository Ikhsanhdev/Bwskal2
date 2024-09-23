<?php

namespace App\Models;

use AyatKyo\Klorovel\Core\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    use HasFactory, ModelTrait;

    const TYPE_IMAGE = 'image';
    const TYPE_POST = 'post';

    public static function getTypeList()
    {
        return [
            self::TYPE_IMAGE => 'Gambar',
            self::TYPE_POST => 'Berita',
        ];
    }
}
