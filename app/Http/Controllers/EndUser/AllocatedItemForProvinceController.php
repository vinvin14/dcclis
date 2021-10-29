<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAllocatedItemProvRequest;
use App\Http\Services\AllocatedItemForProvinceServices;
use App\Http\Services\AllocationProvinceServices;
use App\Models\AllocatedItemForProvince;
use App\Repository\AllocatedItemForProvinceRepository;
use App\Repository\IARItemRepository;
use Illuminate\Http\Request;

class AllocatedItemProvinceController extends Controller
{
    public function show($id, Request $request, AllocatedItemForProvinceRepository $allocatedItemRepository)
    {
        return view('allocation.province.item.show')
        ->with('item', $allocatedItemRepository->get($id, $request->cookie('office')))
        ->with('page', 'allocation');
    }

    public function create($allocation_list_id, Request $request, IARItemRepository $iARItemRepository)
    {
        return view('allocation.province.item.create')
        ->with(compact('allocation_list_id'))
        ->with('iar_items', $iARItemRepository->getItemsByOffice($request->cookie('office')))
        ->with('page', 'allocation');
    }

    public function store($allocation_list_id, StoreAllocatedItemProvRequest $request, AllocationProvinceServices $allocationProvinceServices)
    {
        $request['allocation_list_id'] = $allocation_list_id;
        $init = $allocationProvinceServices->store($request->validated());

        if (@$init['error']) {
            return back()
            ->with('error', $init['error']);
        }

        return redirect('allocation.province.show', $allocation_list_id)
        ->with('success', $init['message']);
    }

    public function edit(AllocatedItemForProvince $allocatedItem, Request $request, IARItemRepository $iARItemRepository)
    {
        return view('allocation.province.item.edit')
        ->with(compact('allocatedItem'))
        ->with('iar_items', $iARItemRepository->getItemsByOffice($request->cookie('office')))
        ->with('page', 'allocation');
    }

    public function update(AllocatedItemForProvince $allocatedItem, Request $request, AllocatedItemForProvinceServices $allocatedItemForProvinceServices)
    {
        $init = $allocatedItemForProvinceServices->update($allocatedItem, $request->only(['requested_qty', 'approved_qty', 'recipient', 'issued_date']));

        if (@$init['error']) {
            return back()
            ->with('error', $init['error']);
        }

        return redirect(route('allocation.province.item.show', $allocatedItem->id))
        ->with('success', $init['message']);
    }

    public function destroy(AllocatedItemForProvince $allocatedItem, AllocatedItemForProvinceServices $allocatedItemForProvinceServices)
    {
        $init = $allocatedItemForProvinceServices->destroy($allocatedItem);

        if (@$init['error']) {
            return back()
            ->with('error', $init['error']);
        }

        return redirect(route('allocation.province.show', $allocatedItem->allocation_list_id))
        ->with('success', 'Item has been successfully deleted!');
    }
}
