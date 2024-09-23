<?php

namespace App\Models;

use AyatKyo\Klorovel\Core\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class LinkTerkait extends Model
{
    use HasFactory, ModelTrait;

    public $table = 'link_terkait';

    const UPLOAD_PATH = 'uploads/link-terkait/';

    public function getLogoImageAttribute()
    {
        $image = 'default.png';
        if ($this->image && File::exists(self::UPLOAD_PATH . $this->image)) {
            $image = $this->image;
        }
        
        return url(self::UPLOAD_PATH . $image);
    }
}
