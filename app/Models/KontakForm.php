<?php

namespace App\Models;

use AyatKyo\Klorovel\Core\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KontakForm extends Model
{
    use HasFactory, ModelTrait;

    public $fillable = [
        'name',
        'email',
        'contact',
        'topic',
        'content',
    ];
}
