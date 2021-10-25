<?php

namespace App\Http\Controllers;

use App\Http\Services\RISServices;
use App\Repository\RISRepository;
use Illuminate\Http\Request;
use App\Models\RIS;
use App\Repository\ItemRepository;
use App\Repository\RisItemRepository;

class RISController extends Controller
{
    public function list(Request $request)
    {
        return view('ris.index')
        ->with('ris', (new RISRepository())->all($request->cookie('office')))
        ->with('module', 'list')
        ->with('page', 'ris');
    }

    public function show($id)
    {   
        return view('ris.index')
        ->with('ris', (new RisRepository())->getRisWIthJoin($id))
        ->with('ris_items', (new RisItemRepository())->getByRis($id))
        ->with('item_categories', (new ItemRepository())->getCategories())
        ->with('module', 'show')
        ->with('page', 'ris');
    }

    public function create(Request $request, RISServices $risServices)
    {
        $init = $risServices->store($request->cookie('office'));
    
        if (@$init['error']) {
            return back()
            ->with('error', $init['error']);
        }
        return redirect(route('ris.show', $init->id))
        ->with('success', 'Request and Issuance Slip record has been created, you can now add some items!');
    }

    public function edit(RIS $ris)
    {
        return view('ris.edit')
        ->with(compact('ris'))
        ->with('page', 'ris');
    }

    public function update(RIS $ris, Request $request, RISServices $risServices)
    {
        $init = $risServices->update($ris, $request->only(['approved_by', 'date_approved', 'status', 'reason_for_status', 'issuance_status']));

        if(@$init['error']) {
            return back()
            ->with('error', $init['error']);
        }

        return redirect(route('ris.show', $init->id))
        ->with('success', 'Request and Issuance Slip record has been successfully updated!');
    }

    public function destroy(RIS $ris, RISServices $risServices) 
    {
        $init = $risServices->destroy($ris);

        if (@$init['error']) {
            return back()
            ->with('error', $init['error']);
        }

        return redirect(route('ris.list'))
        ->with('success', 'Request and Issucance Slip record has been deleted!');
    }
}
