<?php

namespace App\Models;

use AyatKyo\Klorovel\Core\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostCategory extends Model
{
    use HasFactory, ModelTrait, SoftDeletes;

    public $timestamps = false;

    protected $guarded = [];

    const DITJEN_SDA_SLUG = 'ditjen-sda';
}
