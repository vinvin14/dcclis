<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $connection = 'fmtis';
    protected $table = 'items_table';

    public function iarItem()
    {
        return $this->belongsToMany(IarItem::class, 'item_id');
    }

    public function itemCategory()
    {
        return $this->hasOne(ItemCategory::class, 'id');
    }
}
