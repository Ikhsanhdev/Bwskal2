<?php

namespace App\Models;

use AyatKyo\Klorovel\Core\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use HasFactory, ModelTrait, SoftDeletes;

    public function getContentAttribute($value)
    {
        return decode_local_upload($value);
    }

    public function setContentAttribute($value)
    {
        $this->attributes['content'] = encode_local_upload($value);
    }
}
