<?php

namespace App\Models;

use AyatKyo\Klorovel\Core\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Post extends Model
{
    use HasFactory, ModelTrait;

    public const STATUS_DRAFT     = "draft";
    public const STATUS_PENDING   = "pending";
    public const STATUS_PUBLISH   = "publish";
    public const STATUS_UNPUBLISH = "unpublish";

    public function getCoverImageAttribute()
    {
        $image = 'default.png';
        if ($this->cover && File::exists("uploads/post/$this->cover")) {
            $image = $this->cover;
        }
        
        return url('uploads/post/' . $image);
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

    public function scopeJoinCategory($query)
    {
        return $query->join(PostCategory::table(), PostCategory::table('id'), '=', $this->table('category_id'));
    }
}
