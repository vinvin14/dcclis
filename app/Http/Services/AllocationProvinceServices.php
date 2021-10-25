<?php

namespace App\Http\Services;

use App\Models\AllocationProvince;
use App\Repository\AllocationProvinceRepository;
use Exception;
use Illuminate\Support\Carbon;

class AllocationProvinceServices
{
    public function store($request)
    {
        try {
            return AllocationProvince::query()
            ->create($request);
        } catch (Exception $exception) {
            return ['error' => $exception->getMessage()];
        }
    }

    public function update($allocationProvince, $request)
    {
        try {
            $allocationProvince->update($request);
            return $allocationProvince;
        } catch (Exception $exception) {
            return ['error' => $exception->getMessage()];
        }
    }

    public function destroy($allocationProvince)
    {
        try {
            $allocationProvince->delete();
        } catch (Exception $exception) {
            return ['error' => $exception->getMessage()];
        }
    }

    public function generateAllocationNumber($office)
    {
        $allocationProvinceRepository = new AllocationProvinceRepository();
        $stringServices = new StringServices();
        try {
            $allocationNumber = 'AL'.Carbon::now()->year.'-'.$stringServices->threeCodeFormat($office).'-00001';

            if ($allocationProvinceRepository->getCurrentAllocationNumber($office)) {
                list(,,$increment) = explode('-', $allocationProvinceRepository->getCurrentAllocationNumber($office));
                $allocationNumber = 'AL'.Carbon::now()->year.'-'.$stringServices->threeCodeFormat($office).'-'.$stringServices->fiveCodeFormat($increment+1);
            }
            return $allocationNumber;
        } catch (Exception $exception) {
            return ['error' => $exception->getMessage()];
        }
    }
}
