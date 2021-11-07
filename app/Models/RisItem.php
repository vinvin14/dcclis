<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RisItem extends Model
{
    use HasFactory;

    public $table = 'ris_items_table';

    protected $fillable = [
        'ris_id',
        'iar_item_id',
        'request_qty',
        'approved_qty',
        'reason_for_qty',
        'verified_by',
        'created_at',
        'updated_at'
    ];

    public function iar_item()
    {
        return $this->belongsToMany(IarItem::class, 'iaritems_risitems', 'risitem_id', 'iaritem_id')
        ->withTimestamps();
    }
}
