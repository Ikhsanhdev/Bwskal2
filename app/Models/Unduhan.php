<?php

namespace App\Models;

use AyatKyo\Klorovel\Core\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unduhan extends Model
{
    use HasFactory, ModelTrait;

    public $table = 'unduhan';

    const UPLOAD_PATH = "../resources/unduhan/";
    
    public static function getMimeList()
    {
        return implode(",", [
            //  .pdf
            'application/pdf',
            
            //  .ppt, .pptx
            'application/vnd.ms-powerpoint',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation',

            //  .doc, .docx
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',

            //  .xls, .xlsx
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',

            //  .zip
            'application/zip',

            'image/bmp',
            'image/bmp',
            'image/gif',
            'image/jpeg',
            'image/png',
        ]);
    }

    public static function getExtensionList()
    {
        return "pdf, ppt, pptx, doc, docx, xls, xlsx, zip atau gambar";
    }

    public function scopeJoinKategori($query)
    {
        return $query->join(UnduhanKategori::table(), UnduhanKategori::table('id'), '=', $this->table('category_id'));
    }

    public function getFilePathAttribute()
    {
        return public_path(self::UPLOAD_PATH . $this->file);
    }
}
