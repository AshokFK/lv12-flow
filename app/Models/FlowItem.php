<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Model;

class FlowItem extends Model
{
    use CreatedUpdatedBy;

    protected $table = 'flow_item';
    protected $fillable = [
        'header_id',
        'itemable_id',
        'itemable_type',
        'next_to',
        'proses_type',
        'operator',
        'mesin',
        'is_active',
        'left',
        'top',
    ];
    protected $casts = [
        'is_active' => 'boolean',
        'mesin' => 'array',
        'operator' => 'array',
        'next_to' => 'array',
    ];

    public function header()
    {
        return $this->belongsTo(FlowHeader::class);
    }
    public function itemable()
    {
        return $this->morphTo();
    }

}
