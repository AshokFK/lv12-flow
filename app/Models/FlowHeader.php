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
        'lokasi',
        'tgl_berjalan',
        'finished_at',
    ];

    public function items()
    {
        return $this->hasMany(FlowItem::class, 'header_id');
    }
}
