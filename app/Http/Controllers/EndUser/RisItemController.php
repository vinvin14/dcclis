<?php

namespace App\Http\Controllers\EndUser;

use App\Http\Controllers\Controller;
use App\Http\Services\RisItemServices;
use App\Models\RIS;
use App\Models\RisItem;
use App\Repository\RisItemRepository;
use Illuminate\Http\Request;

class RisItemController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(RIS $ris)
    {
        return view('ris.item.create')
        ->with(compact('ris'))
        ->with('page', 'ris');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, RisItemServices $risItemServices)
    {
        $init = $risItemServices->store($request->only(['ris_id', 'iar_item_id', 'request_qty']));

        if (@$init['error']) {
            return back()
            ->with('error', $init['error']);
        }

        return redirect(route('ris.enduser.show', $request['ris_id']))
        ->with('success', 'Item has been successfully added to your RIS record!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RisItem  $risItem
     * @return \Illuminate\Http\Response
     */
    public function show($id, RisItemRepository $risItemRepository)
    {
        return view('ris.item.show')
        ->with('ris_item', $risItemRepository->get($id))
        ->with('page', 'ris');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RisItem  $risItem
     * @return \Illuminate\Http\Response
     */
    public function edit(RisItem $risItem)
    {
        return view('ris.item.edit')
        ->with(compact('risItem'))
        ->with('page', 'ris');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RisItem  $risItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RisItem $risItem, RisItemServices $risItemServices)
    {
        $init = $risItemServices->update($risItem, $request->only(['iar_item_id', 'request_qty', 'approved_qty', 'reason_for_qty', 'verified_by']));

        if (@$init['error']) {
            return back()
            ->with('error', $init['error']);
        }

        return redirect(route('ris.item.show', $risItem->id))
        ->with('success', 'RIS Item has been successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RisItem  $risItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(RisItem $risItem, RisItemServices $risItemServices)
    {
        $ris_id = $risItem->ris_id;
        $init = $risItemServices->destroy($risItem);

        if (@$init['error']) {
            return back()
            ->with('error', $init['error']);
        }

        return redirect(route('ris.show', $ris_id))
        ->with('success', 'RIS Item has been successfully deleted!');
    }

    public function approveRis(RisItem $risItem,Request $request, RisItemServices $risItemServices)
    {
        $init = $risItemServices->approveRequest($risItem, $request);

        if (@$init['error']) {
            return back()
            ->with('error', $init['error']);
        }

        redirect(route('ris.show', $risItem->ris_id))
        ->with('success', 'Ris Item has been successfully approved!');
    }
}
