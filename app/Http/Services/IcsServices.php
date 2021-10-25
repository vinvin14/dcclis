<?php

namespace App\Http\Services;

use App\Models\Ics;
use App\Repository\IcsRepository;
use Carbon\Carbon;
use Exception;

class IcsServices
{
    public function store($request, $office)
    {
        try {
            $request['ics_number'] = $this->generateIcsNum($office);
            return Ics::query()
            ->create($request);
        } catch (Exception $exception) {
            return ['error' => $exception->getMessage()];
        }
    }

    public function generateIcsNum($office)
    {
        $currentIcsNum = (new IcsRepository())->getCurrentIcsNum($office);
        $stringServices = new StringServices();

        if (empty($currentIcsNum)) {
            return 'ICS'.Carbon::now()->year.'-'.$stringServices->threeCodeFormat($office).'-00001';
        }

        list(,,$increment) = explode('-', intval($currentIcsNum));
        return 'ICS'.Carbon::now()->year.'-'.$stringServices->threeCodeFormat($office).'-'.($increment+1);
    }

    public function generatePropertyNumber($office)
    {
        $stringServices = new StringServices();
        $current_property_number = Ics::query()->select('property_number')->orderBy('created_by', 'DESC')->first();
        
        $property_number = 'PN'.Carbon::now()->year.'-'.$stringServices->threeCodeFormat($office).'-00001';
        if (! empty($current_property_number)) {
            list (,,$increment) = explode('-', $current_property_number);
            $property_number = 'PN'.Carbon::now()->year.'-'.$stringServices->threeCodeFormat($office).'-'.$stringServices->fiveCodeFormat($increment+1);
        }

        return $property_number;
    }
}
