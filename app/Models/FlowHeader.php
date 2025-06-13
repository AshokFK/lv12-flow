<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Model;

class FlowHeader extends Model
{
    use CreatedUpdatedBy;
    protected $table = 'flow_header';
    protected $fillable = [
        'brand',
        'pattern',
        'style',
        'kontrak',
        'lokasi_id',
        'tgl_berjalan',
        'finished_at',
        'wrapper_width',
        'wrapper_height',
    ];

    public function items()
    {
        return $this->hasMany(FlowItem::class, 'header_id');
    }

    // relasi header ke lokasi
    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'lokasi_id');
    }
    
}
