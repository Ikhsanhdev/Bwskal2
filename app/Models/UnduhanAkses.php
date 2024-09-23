<?php

namespace App\Models;

use AyatKyo\Klorovel\Core\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnduhanAkses extends Model
{
    use HasFactory, ModelTrait;

    protected $table = 'unduhan_access';

    const STATUS_PENDING = 'pending';
    const STATUS_REJECT  = 'reject';
    const STATUS_APPROVE = 'approve';

    public static function getStatusList()
    {
        return [
            self::STATUS_PENDING => 'Menunggu',
            self::STATUS_REJECT => 'Ditolak',
            self::STATUS_APPROVE => 'Disetujui',
        ];
    }

    public function getStatusTextAttribute()
    {
        return self::getStatusList()[$this->status];
    }

    public function unduhan()
    {
        return $this->belongsTo(Unduhan::class);
    }
}
