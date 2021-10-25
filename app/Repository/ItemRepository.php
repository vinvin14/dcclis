<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;

class ItemRepository
{
    public function getCategories()
    {
        return DB::connection('fmtis')
        ->table('item_category_table')
        ->orderBy('name', 'ASC')
        ->get();
    }

    public function getItems()
    {
        return DB::connection('fmtis')
        ->table('items_table')
        ->orderBy('title', 'ASC')
        ->get();
    }
}
