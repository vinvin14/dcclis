<?php

namespace App\Repository;

use App\Models\Ics;

class IcsRepository
{
    public function getCurrentIcsNum($office)
    {
        return Ics::query()
        ->select(
            'ics_number'
        )
        ->where('office', $office)
        ->orderBy('created_at', 'DESC')
        ->first();
    }
}
