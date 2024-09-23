<?php

namespace App\Models;

use AyatKyo\Klorovel\Core\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory, ModelTrait;

    public function getContentAttribute($value)
    {
        return decode_local_upload($value);
    }

    public function setContentAttribute($value)
    {
        $this->attributes['content'] = encode_local_upload($value);
    }
}
