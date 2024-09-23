<?php

namespace App\Models;

use AyatKyo\Klorovel\Core\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Infografis extends Model
{
    use HasFactory, ModelTrait;

    const UPLOAD_PATH = 'uploads/infografis/';

    public function scopeJoinUser($query)
    {
        return $query->leftJoin(User::table(), User::table('id'), '=', $this->table('user_id'));
    }
}
