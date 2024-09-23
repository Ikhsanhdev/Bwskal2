<?php

namespace AyatKyo\Klorovel\DataTable;

use Yajra\DataTables\QueryDataTable as DataTablesQueryDataTable;

class QueryDataTable extends DataTablesQueryDataTable
{
    //  Tambahkan custom search
    public function addAKSearch($toSearch) {
        if (! is_array($toSearch))
            $toSearch = [$toSearch];

        $this->columnDef['ak_search'] = $toSearch;

        return $this;
    }

    //  Override function global search
    protected function globalSearch($keyword)
    {
        $this->query->where(function ($query) use ($keyword) {
            collect($this->request->searchableColumnIndex())
                ->map(function ($index) {
                    return $this->getColumnName($index);
                })
                ->reject(function ($column) {
                    return $this->isBlacklisted($column) && ! $this->hasFilterColumn($column);
                })
                ->each(function ($column) use ($keyword, $query) {
                    if ($this->hasFilterColumn($column)) {
                        $this->applyFilterColumn($query, $column, $keyword, 'or');
                    } else {
                        $this->compileQuerySearch($query, $column, $keyword);
                    }

                    $this->isFilterApplied = true;
                });
            
            if (isset($this->columnDef['ak_search'])) {
                collect($this->columnDef['ak_search'])
                    ->each(function ($column) use ($keyword, $query) {
                        if ($this->hasFilterColumn($column)) {
                            $this->applyFilterColumn($query, $column, $keyword, 'or');
                        } else {
                            $this->compileQuerySearch($query, $column, $keyword);
                        }

                        $this->isFilterApplied = true;
                    });
            }
        });
    }
}