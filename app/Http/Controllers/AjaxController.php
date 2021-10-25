<?php

namespace App\Http\Controllers;

use App\Models\RIS;
use App\Repository\IARItemRepository;
use App\Repository\RISRepository;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function getRis($id)
    {
        return RIS::query()
        ->find($id);
    }

    public function getItemsForRis($office, $category)
    {
        return (new IARItemRepository())->getIarItemsByOffice($office, $category);
    }
}
