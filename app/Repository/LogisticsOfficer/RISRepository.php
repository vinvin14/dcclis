<?php

namespace App\Repository\LogisticsOfficer;

use App\Models\RIS;

class RISRepository
{
    public function all()
    {
        return RIS::query()
        ->with('items')
        ->orderBy('created_at', 'ASC')
        ->get();
    }

    public function find($id)
    {
        return RIS::query()
        ->with('items')
        ->find($id);
    }

}
