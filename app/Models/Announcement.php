<?php

namespace App\Models;

use AyatKyo\Klorovel\Core\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Announcement extends Model
{
    use HasFactory, ModelTrait;

    protected $dates = [
        'active_from',
        'active_to'
    ];

    public function getCoverImageAttribute()
    {
        $image = 'default.png';
        if ($this->cover && File::exists("uploads/announcement/$this->cover")) {
            $image = $this->cover;
        }
        
        return url('uploads/announcement/' . $image);
    }

    public function getContentAttribute($value)
    {
        return decode_local_upload($value);
    }

    public function setContentAttribute($value)
    {
        $this->attributes['content'] = encode_local_upload($value);
    }
    
    public function scopeJoinUser($query)
    {
        return $query->leftJoin(User::table(), User::table('id'), '=', $this->table('user_id'));
    }
}
