<?php

namespace App\Http\Services\LogisticsOfficer;

use App\Models\RIS;
use Exception;

class RISServices
{
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
        try {
            $ris->delete($ris);
        } catch (Exception $exception) {
            return ['error' => $exception->getMessage()];
        }
    }
}
