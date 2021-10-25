<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;

class PurchaseOrderRepository
{
    public function all()
    {
        return DB::connection('fmis')
        ->table('purchase_orders')
        ->orderBy('created_at', 'ASC')
        ->get();
    }

    public function get($id)
    {
        return DB::connection('fmis')
        ->table('purchase_orders')
        ->find($id);
    }

    public function getItems($id)
    {
        return DB::connection('fmis')
        ->table('items_table')
        ->where('po_id', $id)
        ->get();
    }
}
