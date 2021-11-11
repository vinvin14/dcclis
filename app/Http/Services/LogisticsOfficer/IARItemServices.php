<?php

namespace App\Http\Services\LogisticsOfficer;

use App\Models\IarItem;
use Exception;

class IARItemServices
{
    public function create($request)
    {
        try {
            $request['current_qty'] = $request['beginning_qty'];
            return IarItem::create($request);
        } catch (Exception $exception) {
            return ['error' => $exception->getMessage()];
        }
    }
}
