<?php

namespace App\Http\Controllers\LogisticsOfficer;

use App\Http\Services\LogisticsOfficer\IARItemServices;
use Illuminate\Http\Request;

class IARItemController
{
    public function index()
    {
        // return view('')
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        $init = (new IARItemServices())->create($request->post());

        if (@$init['error']) {
            return back()
            ->with('error', $init['error']);
        }

        return redirect(route('logisticsofficer.iar.show', $init->iar_id))
        ->with('success', 'Item successfully added!');
    }

    public function show()
    {

    }

    public function edit()
    {

    }

    public function update()
    {

    }

    public function destroy()
    {

    }
}
