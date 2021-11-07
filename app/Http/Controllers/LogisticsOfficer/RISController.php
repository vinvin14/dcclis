<?php

namespace App\Http\Controllers\LogisticsOfficer;

use App\Http\Services\LogisticsOfficer\RISServices;
use App\Models\RIS;
use App\Repository\LogisticsOfficer\RISRepository;
use Illuminate\Http\Request;

class RISController
{
    public function index(RISRepository $RISRepository)
    {
        return view('ris.index')
        ->with('requests', $RISRepository->all())
        ->with('module', 'RIS')
        ->with('page', 'RIS');
        
    }

    public function show($id, RISRepository $RISRepository)
    {
        return view('ris.index')
        ->with('ris', $RISRepository->find($id))
        ->with('module', 'RIS')
        ->with('page', 'RIS');
    }

    public function edit(RIS $ris)
    {
        return view('ris.edit')
        ->with(compact('ris'))
        ->with('module', 'RIS')
        ->with('page', 'RIS');
    }

    public function update(RIS $ris, Request $request, RISServices $RISServices)
    {
        $init = $RISServices->update($ris, $request->only(['approved_by', 'date_approved', 'status', 'reason_for_status', 'issuance_status']));

        if (@$init['error']) {
            return back()
            ->with('error', $init['error']);
        }
        return redirect(route('logisticsofficer.ris.show'))
        ->with('success', 'Record has been successfully updated!');
    }

    public function destroy(RIS $ris, RISServices $RISServices)
    {
        $init = $RISServices->destroy($ris);

        if (@$init['error']) {
            return back()
            ->with('error', $init['error']);
        }
    }

}
