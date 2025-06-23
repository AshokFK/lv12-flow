<?php

namespace App\Traits;

use App\Models\Lokasi;

trait FetchLokasi
{
    public function fetchLokasi($query = '')
    {
        return Lokasi::search(['nama', 'sub', 'deskripsi'], $query)->get(['id', 'nama', 'sub', 'deskripsi']);
    }
}
