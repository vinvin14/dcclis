<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemCategory extends Model
{
    use HasFactory;

    protected $connection = 'fmtis';
    protected $table = 'item_category_table';

    public function item()
    {
        return $this->belongsToMany(Item::class, 'category');
    }
}
