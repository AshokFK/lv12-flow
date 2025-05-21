<?php

namespace App\Traits;

trait WithTableTools
{
    public ?string $searchTerm = '';
    public ?string $sortColumn = '';
    public ?string $sortDirection = 'asc';

    public function sortBy($column)
    {
        $this->sortDirection = $this->sortColumn === $column
            ? $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc'
            : 'asc';

        $this->sortColumn = $column;
    }
}
