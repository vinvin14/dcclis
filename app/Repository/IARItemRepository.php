<?php

namespace App\Repository;

use App\Models\IarItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class IARItemRepository
{
    public function get($id)
    {
        return DB::table('iar_item_table')
        ->leftJoin('fmtis.items_table as item_table', 'iar_items_table.item_id', '=', 'item_table.id')
        ->leftJoin('fmtis.items_category as item_category_table', 'item_table.category_id', '=', 'item_category_table.id')
        ->select(
            'allocated_items_for_province.*',
            'item_table.title as title',
            'item_table.category_id as category_id',
            'item_category_table.name as category_name',
            'item_table.specifications'
        )
        ->where('iar_item_table.id', $id)
        ->first();
    }

    public function getIarItemsByOffice($office, $category)
    {
        $ris_items = DB::table('ris_items_table')
        ->leftJoin('ris_table', 'ris_items_table.ris_id', '=', 'ris_table.id')
        ->select(
            'ris_items_table.iar_item_id',
            DB::raw('sum(request_qty) as all_request_qty')
        )
        ->where([
            'ris_table.status' => 'pending',
            'ris_items_table.status' => 'pending'
        ])
        ->groupBy('ris_items_table.iar_item_id');


        return DB::table('iar_items_table')
        ->leftJoin('fmtis.items_table as item_table', 'iar_items_table.item_id', '=', 'item_table.id')
        ->leftJoin('fmtis.item_category_table as item_category_table', 'item_table.category', '=', 'item_category_table.id')
        ->leftJoinSub($ris_items, 'ris_items', function ($join) {
            $join->on('iar_items_table.id', '=', 'ris_items.iar_item_id');
        })
        ->select(
            'iar_items_table.*',
            'item_table.title as title',
            'item_table.category as category_id',
            'item_category_table.name as category_name',
            'item_table.specifications',
            'ris_items.all_request_qty',
            DB::raw('SUM(
                CASE WHEN iar_items_table.expiration_date IS NULL 
                OR (iar_items_table.expiration_date IS NOT NULL AND iar_items_table.expiration_date > '.Carbon::now()->toDateString().') 
                THEN iar_items_table.current_qty
                ELSE 0 END) - (CASE WHEN ris_items.all_request_qty IS NULL THEN 0 ELSE ris_items.all_request_qty END) 
                as remaining_qty')
            // DB::raw('IF(iar_items_table.expiration_date IS NULL, SUM(iar_items_table.current_qty), SUM(CASE WHEN iar_items_table.expiration_date > '.Carbon::now()->toDateString().' THEN iar_items_table.current_qty END)) as remaining_qty')
        )
        ->where(
            [
                'iar_items_table.receiving_office' => $office,
                'item_table.category' => $category
            ]
        )
        ->groupBy('iar_items_table.id')
        ->having('remaining_qty', '!=', 0)
        ->get();
    }

    public function hasIssued($id)
    {
        return IarItem::query()
        ->where('issued_qty', '!=', 0)
        ->find($id);
    }

    public function getStock($qty, $iar_id)
    {
        DB::statement('SET @order ='.$qty);
        $first = DB::table('iar_items_table')
        ->selectRaw(
            '*, @order := IF(@order > 0 AND current_qty > @order, 0, @order - CAST(current_qty AS SIGNED)) as stocks_left'
        )
        ->whereRaw('iar_id = '.$iar_id);

        return DB::table(DB::raw('('.$first->toSql().') as stocks'))
        ->select('*')
        // ->where('stock2.order_left', '>=', 0)
        ->whereRaw('stocks.stocks_left >= 0')
        ->get();
    }
}
