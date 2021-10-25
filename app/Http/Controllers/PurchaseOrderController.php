<?php

namespace App\Http\Controllers;

use App\Repository\PurchaseOrderRepository;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    public function list(PurchaseOrderRepository $purchaseOrderRepository)
    {
        return view('purchaseOrder.list')
        ->with('purchaseOrders', $purchaseOrderRepository->all())
        ->with('page', 'purchase_order');
    }

    public function show($id, PurchaseOrderRepository $purchaseOrderRepository)
    {
        return view('purchaseOrder.show')
        ->with('purchaseOrder', $purchaseOrderRepository->get($id))
        ->with('page', 'purchase_order');
    }

    
}
