<?php

namespace App\Models;

use AyatKyo\Klorovel\Core\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Gallery extends Model
{
    use HasFactory, ModelTrait;

    const UPLOAD_PATH = 'uploads/gallery/';

    const TYPE_ALBUM = 'album';
    const TYPE_IMAGE = 'image';
    const TYPE_VIDEO = 'video';

    public function getThumbsImageAttribute()
    {
        if ($this->type == self::TYPE_VIDEO) {
            return "https://i.ytimg.com/vi/$this->content/mqdefault.jpg";
        }
        
        $image = 'default.png';
        if ($this->content && File::exists("uploads/gallery/thumbs_$this->content")) {
            $image = "thumbs_$this->content";
        }
        
        return url('uploads/gallery/' . $image);
    }
}
