<?php

namespace App\Http\Services;

use App\Models\RIS;
use App\Repository\RISRepository;
use Carbon\Carbon;
use Exception;

class RISServices
{
    public function store($office)
    {
        try {
            $request['ris_number'] = $this->generateRisNum($office);
            $request['requesting_office'] = $office;
            return RIS::query()->create($request);
        } catch (Exception $exception) {
            return ['error' => $exception->getMessage()];
        }
    }

    public function update($ris, $request)
    {
        try {
            $ris->update($request);
            return $ris;
        } catch (Exception $exception) {
            return ['error' => $exception->getMessage()];
        }
    }

    public function destroy($ris)
    {
        // dd($ris);
        
        if ((new RISRepository())->hasRisItems($ris->id)) {
            return ['error' => 'cannot be deleted since it has existing items recorded!'];
        }

        try {
            $ris->delete();
        } catch (Exception $exception) {
            return ['error' => $exception->getMessage()];
        }
    }

    public function generateRisNum($office)
    {
        $risRepository = new RISRepository();
        $stringServices = new StringServices();

        $currentRisNum = $risRepository->getCurrentRis($office);

        if (empty($currentRisNum)) {
            $risNum = 'RIS'.Carbon::now()->year.'-'.$stringServices->twoCodeFormat(Carbon::now()->month).'@'.$office.'-'.'00001';
        }
        else {
            list(,,$increment) = explode('-', $currentRisNum);
            $risNum = 'RIS'.Carbon::now()->year.'-'.$stringServices->twoCodeFormat(Carbon::now()->month).'@'.$office.'-'.$stringServices->fiveCodeFormat(intval($increment)+1);
        }

        return $risNum;
    }
}
