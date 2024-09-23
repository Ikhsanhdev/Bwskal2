<?php

namespace App\Models;

use AyatKyo\Klorovel\Core\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnduhanKategori extends Model
{
    use HasFactory, ModelTrait;

    public $table = 'unduhan_kategori';
    public $timestamps = false;

    public function scopeGetSelectOptions($query)
    {
        return $query
            ->select('id', 'name')->get()
            ->mapWithKeys(fn ($item) => [$item->id => $item->name]);
    }
}
