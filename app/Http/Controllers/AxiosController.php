<?php

namespace App\Http\Controllers;

use App\Models\IarItem;
use App\Models\Item;
use App\Models\Office;
use Exception;
use Illuminate\Http\Request;

class AxiosController extends Controller
{
    public function itemsByCategory(Request $request)
    {
        $query = Item::query();
        switch (true)
        {
            case $request->input('category') :
                return $query->where('category', $request->input('category'))
                ->orderBy('title', 'asc')
                ->get();
                break;

            case $request->input('id') :
                return $query->where('id', $request->input('id'))
                ->first();
                break;

            case $request->input('keyword') :
                return $query->where('title', 'like', '%'. $request->input('keyword') . '%')
                ->limit(5)
                ->get();
                break;

            default :
            return Item::orderBy('title', 'ASC')->get();
        }
    }

    public function offices()
    {
        return Office::orderBy('name', 'ASC')->get();
    }

    public function getIarItem(Request $request)
    {
        $query = IarItem::query();
        switch (true)
        {
            case $request->input('id') :
                return $query->with('item')->find($request->input('id'));
                break;
        }

    }

    public function udpateIarItem($id, Request $request)
    {
        try {
            $iarItem = IarItem::with('item')->where('id', $id)->first();

            if (! empty($iarItem->issued_qty)) {
                return response()->json('cannot be issued!', 404);
            }
            $iarItem->update($request->post());
            // IarItem::where('id', $id)
            // ->update($request->post());
            return response()->json($iarItem->item->title. ' has been successfully updated!');

        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }
}
