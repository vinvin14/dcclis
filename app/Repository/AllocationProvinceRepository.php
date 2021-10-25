<?php

namespace App\Repository;

use App\Models\AllocationProvince;
use Illuminate\Support\Facades\DB;

class AllocationProvinceRepository
{
    public function all()
    {
        return AllocationProvince::query()
        ->orderBy('created_at', 'ASC')
        ->get();
    }

    public function allByOffice($office)
    {   
        return AllocationProvince::query()
        ->where('office', $office)
        ->orderBy('created_by', 'ASC')
        ->get();
    }

    public function getAllocatedItems($id)
    {
        return DB::table('allocated_items_for_province')
        ->leftJoin('iar_items_table', 'allocated_items_for_province.iar_items_id', '=', 'iar_items_table.id')
        ->leftJoin('fmtis.items_table as items_table', 'iar_items_table.item_id', '=', 'items_table.id')
        ->leftJoin('fmtis.items_category as items_category_table', 'items_table.category_id', '=', 'items_category_table.id')
        ->select(
            'allocated_items_for_province.*',
            'items_table.title as title',
            'items_table.category_id as category_id',
            'items_category_table.name as category_name',
            'items_table.specifications as specifications'
            )
        ->where('allocation_list_id', $id)
        ->get();
    }

    public function getCurrentAllocationNumber($office)
    {
        return AllocationProvince::query()
        ->where('office', $office)
        ->orderBy('created_at', 'DESC')
        ->first();
    }
}
