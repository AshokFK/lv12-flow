<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Model;

class Komponen extends Model
{
    use CreatedUpdatedBy;
    
    protected $table = 'komponen';
    protected $fillable = [
        'nama',
        'type',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
