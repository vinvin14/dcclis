<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RisItem extends Model
{
    use HasFactory;

    public $table = 'ris_items_table';
    
    protected $fillable = [
        'ris',
        'iar_item_id',
        'request_qty',
        'approved_qty',
        'reason_for_qty',
        'verified_by',
        'created_at',
        'updated_at'
    ];
}
