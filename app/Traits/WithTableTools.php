<?php

namespace App\Traits;

trait WithTableTools
{
    public ?string $searchTerm = '';
    public ?string $sortColumn = 'created_at';
    public ?string $sortDirection = 'desc';
    public ?string $perPage = '10';

    protected $queryString = ['sortColumn', 'sortDirection', 'searchTerm', 'perPage'];

    public function sortBy($column)
    {
        $this->sortDirection = $this->sortColumn === $column
            ? $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc'
            : 'asc';

        $this->sortColumn = $column;
    }
}
