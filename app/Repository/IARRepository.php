<?php

namespace App\Repository;
use App\Models\Iar;

class IARRepository
{
    public function all()
    {
        return Iar::query()
        ->orderBy('created_at', 'ASC')
        ->get();
    }

    public function getCurrentIARNum()
    {
        return Iar::query()
        ->select(
            'iar_number'
        )
        ->orderBy('created_at', 'DESC')
        ->first();
    }
}

