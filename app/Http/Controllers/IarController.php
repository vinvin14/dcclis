<?php

namespace App\Http\Controllers;

use App\Http\Services\IARServices;
use App\Models\Iar;
use App\Repository\IARRepository;
use App\Repository\PurchaseOrderRepository;
use Illuminate\Http\Request;

class IarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(IARRepository $iarRepository)
    {
        return  $iarRepository->all();
        return view('iar.list')
        ->with('iar_lists', $iarRepository->all())
        ->with('page', 'IAR');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('iar.create')
        ->with('page', 'IAR');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, IARServices $iarServices)
    {
        $init = $iarServices->store($request->only(['pr_id', 'logistics_officer', 'ptr_number']));
        dd($init);
        if (@$init['error']) {
            return back()
            ->with('error', $init['error']);
        }

        return $init;

        return redirect(route('iar.show', $init->id))
        ->with('success', 'IAR Record has been created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Iar  $iar
     * @return \Illuminate\Http\Response
     */
    public function show(Iar $iar)
    {
        return view('iar.show')
        ->with(compact('iar'))
        ->with('page', 'IAR');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Iar  $iar
     * @return \Illuminate\Http\Response
     */
    public function edit(Iar $iar)
    {
        return view('iar.edit')
        ->with(compact('iar'))
        ->with('page', 'IAR');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Iar  $iar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Iar $iar, IARServices $iarServices)
    {
        dd($request->post());
        $init = $iarServices->update($iar, $request->only(['pr_id', 'logistics_officer', 'ptr_number']));
        if (@$init['error']) {
            return back()
            ->with('error', $init['error']);
        }
        
        return redirect('iar.show', $iar->id)
        ->with('success', 'IAR record has been successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Iar  $iar
     * @return \Illuminate\Http\Response
     */
    public function destroy(Iar $iar, IARServices $iarServices)
    {
        $init = $iarServices->destroy($iar);

        if (@$init['error']) {
            return back()
            ->with('error', $init['error']);
        }

        return redirect(route('iar.list'))
        ->with('success', 'IAR Record successfully deleted!');
    }

    public function createItemsFromPO($id, $po_number, PurchaseOrderRepository $purchaseOrderRepository, IARServices $iarServices)
    {
        $iarItems = $purchaseOrderRepository->getItems($po_number);
        
        $init = $iarServices->createItemsFromPO($id, $iarItems);

        if (@$init['error']) {
            return back()
            ->with('error', $init['error']);
        }

        return redirect(route('iar.show', $id))
        ->with('success', 'Items from the Purchase Order record has been successfully added!');
    }
}
