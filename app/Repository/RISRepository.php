<?php

namespace App\Repository;

use App\Models\IarItem;
use App\Models\RIS;
use App\Models\RisItem;
use Illuminate\Support\Facades\DB;

class RISRepository
{
    public function all(int $office)
    {
        $query = DB::table('ris_table')
                ->leftJoin('ris_items_table', 'ris_table.id', '=', 'ris_items_table.ris_id')
                ->select(
                    'ris_table.*',
                    DB::raw('count(ris_items_table.id) as total_items')
                )
                ->groupBy('ris_table.id')
                ->orderBy('created_at', 'DESC');

        if (!empty ($office))
        {
            $query = $query->where('requesting_office', $office);
        } 

        return $query->get();
    }

    public function getRisWIthJoin($id)
    {
        return DB::table('ris_table')
        ->leftJoin('fmtis.offices as offices', 'ris_table.requesting_office', '=', 'offices.id')
        ->select(
            'ris_table.*',
            'offices.name as office_name'
        )
        ->where('ris_table.id', $id)
        ->first();
    }

    public function getCurrentRis($office)
    {
        return RIS::query()
        ->select(
            'ris_number'
        )
        ->where('requesting_office', $office)
        ->orderBy('created_at', 'DESC')
        ->first();
    }

    public function hasRisItems($id)
    {
        $risItems = RisItem::query()
        ->where('ris_id', $id)
        ->first();

        if (! empty($risItems)) {
            return true;
        }

        return false;
    }
}
