<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Masalah extends Model
{
    protected $table = 'masalah';

    protected $fillable = [
        'flow_item_id',
        'type',
        'deskripsi',
        'penanganan',
        'done_at',
        'saved_at',
        'posted_at',
    ];

    protected $cast = [
        'done_at' => 'datetime',
        'saved_at' => 'datetime',
        'posted_at' => 'datetime',
    ];

    public function flowItem()
    {
        return $this->belongsTo(FlowItem::class);
    }
    
}
