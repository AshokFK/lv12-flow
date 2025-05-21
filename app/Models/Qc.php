<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Model;

class Qc extends Model
{
    use CreatedUpdatedBy;
    protected $table = 'qc';
    protected $fillable = [
        'nama',
        'is_active',
    ];
    protected $casts = [
        'is_active' => 'boolean',
    ];
}
