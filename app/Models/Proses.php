<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proses extends Model
{
    protected $table = 'proses';

    protected $fillable = [
        'mastercode',
        'lokasi_id',
        'nama',
        'nama_jp',
        'level',
        'is_active',
    ];
    protected $casts = [
        'is_active' => 'boolean',
        'level' => 'integer',
    ];

    // relasi ke lokasi
    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
