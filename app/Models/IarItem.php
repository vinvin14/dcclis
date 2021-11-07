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

    public function ris_item()
    {
        return $this->belongsToMany(RisItem::class, 'iaritems_risitems', 'iaritem_id', 'risitem_id')
        ->withTimestamps();
    }

    public function item()
    {
        return $this->hasOne(Item::class);
    }

    public function office()
    {
        return $this->hasOne(Office::class);
    }
}
