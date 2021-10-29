<?php

namespace App\Http\Controllers;

use App\Models\RIS;
use App\Repository\IARItemRepository;

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

    public function getIarItem($office, $id)
    {
        return (new IARItemRepository())->getIarItem($office, $id);
    }
}
