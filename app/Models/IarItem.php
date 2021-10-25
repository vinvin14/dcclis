<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IarItem extends Model
{
    use HasFactory;
    public $table = 'iar_items_table';

    protected $fillable = [
        'beginning_qty',
        'current_qty',
        'issued_qty',
        'iar_id',
        'item_id',
        'receiving_office',
        'status',
        'expiration_date',
        'lot_batch_number',
        'created_at',
        'updated_at'

    ];
}
