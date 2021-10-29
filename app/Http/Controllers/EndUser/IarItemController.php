<?php

namespace App\Http\Controllers;

use App\Http\Services\IARItemServices;
use App\Models\IarItem;
use App\Repository\IARItemRepository;
use App\Repository\ItemRepository;
use Illuminate\Http\Request;

class IarItemController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('iar.item.create')
        ->with('page', 'IAR');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, IARItemServices $iarItemServices)
    {
        $init = $iarItemServices->store($request->only(['beginning_qty', 'issued_qty', 'iar_id', 'item_id', 'receiving_office', 'expiration_date', 'lot_batch_number']));
        dd($init);
        if (@$init['error']) {
            return back()
            ->with('error', $init['error']);
        }

        return redirect(route('iar.item.show', $init->id))
        ->with('success', 'Item has been added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Iar  $iar
     * @return \Illuminate\Http\Response
     */
    public function show($id, IARItemRepository $iarItemRepository)
    {
        return view('iar.item.show')
        ->with('iar_item', $iarItemRepository->get($id))
        ->with('page', 'IAR');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Iar  $iar
     * @return \Illuminate\Http\Response
     */
    public function edit(IarItem $iarItem, Request $request, ItemRepository $itemRepository)
    {
        return view('iar.item.edit')
        ->with(compact('iarItem'))
        ->with('categories', $itemRepository->getCategories())
        ->with('items', $itemRepository->getItems());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Iar  $iar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, IarItem $iarItem, IARItemServices $iarItemServices)
    {
        $init = $iarItemServices->update($iarItem, $request->post());
        
        if (@$init['error']) {
            return back()
            ->with('error', $init['error']);
        }

        return redirect(route('iar.item.show'))
        ->with('success', 'IAR Item record has been successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Iar  $iar
     * @return \Illuminate\Http\Response
     */
    public function destroy(IarItem $iarItem, IARItemServices $iarItemServices,IARItemRepository $iarItemRepository)
    {
        $iar = $iarItem->iar_id;
        if ($iarItemRepository->hasIssued($iarItem->id)) {
            return back()
            ->with('error', 'Request Denied, Item cannot be deleted since it has been referenced or issued!');
        }

        $init = $iarItemServices->destroy($iarItem);

        if (@$init['error']) {
            return back()
            ->with('error', $init['error']);
        }
        
        return redirect(route('iar.show', $iar))
        ->with('success', 'Item record has been successfully deleted!');
    }
}
