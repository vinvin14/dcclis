<?php

namespace App\Http\Controllers;

use App\Http\Services\AllocationProvinceServices;
use App\Models\AllocationProvince;
use App\Repository\AllocationProvinceRepository;
use Illuminate\Http\Request;

class AllocationProvinceController extends Controller
{
    public function list(Request $request, AllocationProvinceRepository $allocationProvinceRepository)
    {
        $lists = $allocationProvinceRepository->all();
        if ($request->cookie('office')) {
            $lists = $allocationProvinceRepository->allByOffice($request->cookie('office'));
        }
        
        return view('allocation.province.list')
        ->with(compact('lists'))
        ->with('page', 'allocation');

    }

    public function show(AllocationProvince $allocation, AllocationProvinceRepository $allocationProvinceRepository)
    {
        return view('allocation.province.show')
        ->with(compact('allocation'))
        ->with('allocated_items', $allocationProvinceRepository->getAllocatedItems($allocation->id))
        ->with('page', 'allocation');
    }

    public function create($allocationID)
    {
        return view('allocation.province.create')
        ->with('page', 'allocation');
    }

    public function store(Request $request, AllocationProvinceServices $allocationProvinceServices)
    {
        $request['allocation_list_number'] = $allocationProvinceServices->generateAllocationNumber($request->cookie('office'));
        $init = $allocationProvinceServices->store($request->post());
        
        if (@$init['error']) {
            return back()
            ->with('error', $init['error']);
        }

        return redirect(route('allocation.province.show', $init->id))
        ->with('success', 'Allocation List record has been successfully added, you can now start adding items!');
    }

    public function edit(AllocationProvince $allocation)
    {
        return view('allocation.province.edit')
        ->with(compact('allocation'))
        ->with('page', 'allocation');
    }

    public function update(AllocationProvince $allocation, Request $request, AllocationProvinceServices $allocationProvinceServices)
    {
        $init = $allocationProvinceServices->update($allocation, $request);

        if (@$init['error']) {
            return back()
            ->with('error', $init['error']);
        }

        return redirect(route('allocation.province.show', $init->id))
        ->with('success', 'Allocation List record has been successfully updated!');

    }

    public function destroy(AllocationProvince $allocation, AllocationProvinceServices $allocationProvinceServices)
    {
        $init = $allocationProvinceServices->destroy($allocation);

        if (@$init['error']) {
            return back()
            ->with('error', $init['error']);
        }

        return redirect(route('allocation.province.list'))
        ->with('success', 'Allocation List record has been successfully deleted!');
    }
}
