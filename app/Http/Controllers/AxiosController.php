<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class AxiosController extends Controller
{
    public function itemsByCategory(Request $request)
    {
        
        switch (true)
        {
            case $request->input('category') :
                return Item::where('category', $request->input('category'))
                ->orderBy('title', 'asc')
                ->get();
                break;

            case $request->input('id') : 
                return Item::where('id', $request->input('id'))
                ->first();
                break;
        }
    }
}
