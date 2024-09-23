<?php

namespace App\Models;

use AyatKyo\Klorovel\Core\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory, ModelTrait;

    public $table = 'agenda';

    const UPLOAD_PATH = 'uploads/agenda/';

    protected $dates = [
        'begin_at',
        'end_at',
    ];

    public static function getUploadMimes()
    {
        return 'application/pdf,application/vnd.ms-powerpoint,application/vnd.openxmlformats-officedocument.presentationml.presentation,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/zip,image/bmp,image/gif,image/jpeg,image/png';
    }

    public static function getUploadMimesMessage()
    {
        return 'Berkas harus berupa pdf, ppt, pptx, doc, docx, xls, xlsx, zip atau gambar';
    }

    public function getAttachmentUrlAttribute()
    {
        return $this->attachment ? url(self::UPLOAD_PATH . $this->attachment) : null;
    }

    public function getDateRangeTextAttribute()
    {
        return carbon_range_text($this->begin_at, $this->end_at);
    }
}
