<?php

namespace App\Http\Services;

use App\Models\IarItem;
use Exception;

class IARItemServices
{
    public function store($request)
    {
        try {
            $request['current_qty'] = $request['beginning_qty'];
            return IarItem::query()
            ->create($request);
        } catch (Exception $exception) {
            return ['error' => $exception->getMessage()];
        }
    }

    public function update($iarItem, $request)
    {
        
        try {
            if ($iarItem->beginning_qty == $iarItem->current_qty) {
                $request['current_qty'] = $request['beginning_qty'];
            }

            $iarItem->update($request);
            return $iarItem;
        } catch (Exception $exception) {
            return ['error' => $exception->getMessage()];
        }
    }

    public function destroy($iarItem)
    {
        try {
            $iarItem->delete($iarItem);
        } catch (Exception $exception) {
            return ['error' => $exception->getMessage()];
        }
    }

}
