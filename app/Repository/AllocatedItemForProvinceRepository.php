<?php

namespace App\Repository;
use Illuminate\Support\Facades\DB;

class AllocatedItemForProvinceRepository
{
    public function get($id, $office)
    {
        return DB::table('allocated_items_for_province')
        ->leftJoin('iar_items_table', 'allocated_items_for_province.iar_item_id', '=', 'iar_items_table.id')
        ->leftJoin('fmtis.items_table as item_table', 'iar_items_table.item_id', '=', 'item_table.id')
        ->leftJoin('fmtis.items_category as item_category_table', 'item_table.category_id', '=', 'item_category_table.id')
        ->select(
            'allocated_items_for_province.*',
            'item_table.title as title',
            'item_table.category_id as category_id',
            'item_category_table.name as category_name',
            'item_table.specifications'
        )
        ->get();
    }
}
