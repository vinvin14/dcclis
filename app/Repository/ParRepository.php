<?php

namespace App\Repository;

use App\Models\Par;

class ParRepository
{
    public function getCurrentParNum()
    {
        return Par::query()
        ->select(
            'par_number'
        )
        ->orderBy('created_at', 'DESC')
        ->first();
    }
}
