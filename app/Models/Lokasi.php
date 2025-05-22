<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    use CreatedUpdatedBy;

    protected $table = 'lokasi';
    protected $fillable = [
        'nama',
        'sub',
        'deskripsi',
        'is_active',
    ];
    protected $casts = [
        'is_active' => 'boolean',
    ];
}
