<?php

namespace AyatKyo\Klorovel\Core\Traits;

/**
 * @method static static|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder table($field = null, $withPrefix = false)
 * @method static static|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder tidakDihapus()
 * @method static static|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder yangId($id)
 */
trait ModelTrait
{
    public function scopeTable($query, $field = null, $prefix = false) {
        return ($prefix ? $query->getModel()->getConnection()->getTablePrefix() : '') . $query->getModel()->getTable() . ($field ? '.' . $field : '');
    }

    public function scopeTableAs($query, $nama, $prefix = false) {
        return ($prefix ? $query->getModel()->getConnection()->getTablePrefix() : '') . $query->getModel()->getTable() . ' as ' . $nama;
    }

    public function scopeHasId($query, $id) {
        if (is_array($id)) {
            return $query->whereIn($this->table($this->primaryKey), $id);
        }
        return $query->where($this->table($this->primaryKey), $id);
    }
    
    public function getPresenUpdatedAtFormat1()
    {
        return $this->updated_at->isoFormat('dddd, DD MMMM YYYY - HH:mm');
    }
}