<?php

namespace App\Repository;

use App\Models\RisItem;
use IcsTable;
use Illuminate\Support\Facades\DB;

class RisItemRepository
{
    public function getByRis($ris)
    {
        return DB::table('ris_items_table')
        ->leftJoin('iar_items_table', 'ris_items_table.iar_item_id', '=', 'iar_items_table.id')
        ->leftJoin('fmtis.items_table as item_table', 'iar_items_table.item_id', '=', 'item_table.id')
        ->leftJoin('fmtis.item_category_table as item_category_table', 'item_table.category', '=', 'item_category_table.id')
        ->select(
            'ris_items_table.*',
            'item_table.title as title',
            'item_table.category as category_id',
            'item_category_table.name as category_name',
            'item_table.specifications'
        )
        ->where('ris_items_table.ris_id', $ris)
        ->get();
    }

    public function get($id)
    {
        return DB::table('ris_item_table')
        ->leftJoin('iar_items_table', 'ris_item_table.iar_item_id', '=', 'iar_items_table.id')
        ->leftJoin('fmtis.items_table as item_table', 'iar_items_table.item_id', '=', 'item_table.id')
        ->leftJoin('fmtis.items_category as item_category_table', 'item_table.category_id', '=', 'item_category_table.id')
        ->select(
            'ris_item_table.*',
            'item_table.title as title',
            'item_table.category_id as category_id',
            'item_category_table.name as category_name',
            'item_table.specifications'
        )
        ->where('ris_item_table.id', $id)
        ->first();
    }

    public function isExisting($ris_id, $iar_item_id)
    {
        $isExisiting = RisItem::query()
        ->where([
            'ris_id' => $ris_id,
            'iar_item_id' => $iar_item_id
        ])
        ->first();

        if ($isExisiting) {
            return true;
        }
        return false;
    }

    public function getApprovedRisItems($ris_id)
    {
        return DB::table('ris_items_table')
        ->leftJoin('iar_items_table', 'ris_items_table.iar_item_id', '=', 'iar_items_table.id')
        ->leftJoin('fmis.items_table as item_table', '')
        ->where([
            'ris_id' => $ris_id,
            'status' => 'approved'
        ])
        ->get();
    }
}
