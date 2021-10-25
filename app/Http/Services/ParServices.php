<?php

namespace App\Http\Services;

use App\Models\Par;
use App\Repository\ParRepository;
use Exception;
use Illuminate\Support\Carbon;

class ParServices
{   
    public function store($request, $office)
    {
        try {
            $request['par_number'] = $this->generateParNum($office);
            return Par::query()->create($request);
        } catch (Exception $exception) {
            return ['error' => $exception->getMessage()];
        }
    }

    public function update($par, $request)
    {
        try {
            $current_par_num = $par->par_number;
            if ($request['office'] != $par->office) {
                list($par_year,$office,$increment) = explode('-', $par->par_number);
                $current_par_num = $par_year.'-'.(new StringServices())->threeCodeFormat($request['office']).'-'.$increment;
            }
            $par->update(
                [
                    'par_number' => $current_par_num,
                    'mr_to' => $request['mr_to'],
                    'office' => $request['office']
                ]
            );
            return $par;
        } catch (Exception $exception) {
            return ['error' => $exception->getMessage()];
        }
    }

    public function generateParNum($office)
    {
        $currentParNum = (new ParRepository)->getCurrentParNum($office);
        $stringServices = new StringServices();
        $par_num = 'PAR'.Carbon::now()->year.'-'.$stringServices->threeCodeFormat($office).'-00001';

        if (! empty($currentParNum)) {
            list(,,$increment) = explode('-', $currentParNum);
            $par_num = 'PAR'.Carbon::now()->year.'-'.$stringServices->threeCodeFormat($office).$stringServices->fiveCodeFormat(intval($increment)+1);
        }

        return $par_num;
    }

    public function generatePropertyNumber($office)
    {
        $stringServices = new StringServices();
        $current_property_number = Par::query()->select('property_number')->orderBy('created_by', 'DESC')->first();
        
        $property_number = 'PN'.Carbon::now()->year.'-'.$stringServices->threeCodeFormat($office).'-00001';
        if (! empty($current_property_number)) {
            list (,,$increment) = explode('-', $current_property_number);
            $property_number = 'PN'.Carbon::now()->year.'-'.$stringServices->threeCodeFormat($office).'-'.$stringServices->fiveCodeFormat($increment+1);
        }

        return $property_number;
    }
}
