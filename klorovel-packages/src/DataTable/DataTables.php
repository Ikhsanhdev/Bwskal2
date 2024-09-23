<?php

namespace AyatKyo\Klorovel\DataTable;

use Yajra\DataTables\DataTables as DataTablesDataTables;

class DataTables extends DataTablesDataTables
{
    public static function _config()
    {
        //  Config lewat sini agar tidak perlu publish config dll
        config([
            'datatables.index_column' => '_no',
            'datatables.engines.eloquent' => EloquentDataTable::class,
            'datatables.engines.query' => QueryDataTable::class,
        ]);
    }

    public static function of($source, $withIndex = true)
    {
        self::_config();

        $ret = self::make($source);

        if ($withIndex) $ret = $ret->addIndexColumn();

        return $ret;
    }

    public static function makeWithSearch($source, $searchList = [], $withIndex = true)
    {
        self::_config();
        $ret = self::make($source);

        if ($withIndex) $ret = $ret->addIndexColumn();

        return $ret->addAKSearch($searchList); 
    }
}
