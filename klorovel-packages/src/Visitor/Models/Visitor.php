<?php

namespace AyatKyo\Klorovel\Visitor\Models;

use AyatKyo\Klorovel\Core\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Visitor extends Model
{
    use ModelTrait;

    public $timestamps = false;

    protected $guarded = [];

    const CREATED_AT = 'visit_at';

    protected $casts = [
        'visit_at' => 'datetime',
    ];

    public function scopeVisitCount($query)
    {
        return $query
            ->groupBy('data')
            ->groupBy(DB::raw('DATE(visit_at)'))
            ->get('data')
            ->count();
    }
}
