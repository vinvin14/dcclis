<?php

namespace App\Http\Services;

use App\Models\AllocatedItemForProvince;
use App\Models\IarItem;
use Exception;
use Illuminate\Support\Facades\DB;

class AllocatedItemForProvinceServices
{
    public function store($request)
    {
        DB::beginTransaction();
        try {
            $item = $this->allocateIarItem($request['iar_item_id'], $request['request_qty']);
            $request['approved_qty'] = $item['allocated'];
            
            AllocatedItemForProvince::query()
            ->create($request);
            DB::commit();
            return [
                'message' => 'Item(s) for allocation has been successfully added'.($item['unaccommodated'] != 0) ? ' with total of '.$item['unaccomodated'].' unaccommodated quantity!' : '!'
            ];

        } catch (Exception $exception) {
            DB::rollback();
            return ['error' => $exception->getMessage()];
        }
    }

    public function allocateIarItem($id,int $qty)
    {
        $iar_item = IarItem::query()->findOrFail($id);
        $remaing_iar_item = $iar_item->current_qty;
        $allocated = 0;
        $unaccommodated = 0;

        if ($remaing_iar_item = 0) {
            return ['error' => 'Request Denied, Item(s) had been issued!'];
        }

        if ($remaing_iar_item > $qty){
            $remaing_iar_item =  $remaing_iar_item - $qty;
            $allocated = $qty;
        }
        else {
            $result = $remaing_iar_item - $qty;
            if ($result <= 0) {
                $allocated = $remaing_iar_item;
                $unaccommodated = abs($result);
                $remaing_iar_item = 0;
            }
        }

        $iar_item->update(['current_qty' => $remaing_iar_item, 'issued_qty' => ($iar_item->issued_qty + $allocated)]);
        
        return ['allocated' => $allocated, 'unaccommodated' => $unaccommodated];
    }

    public function update($allocatedItem, $request)
    {
        DB::beginTransaction();
        try {
            if ($request['request_qty'] != $allocatedItem->approved_qty) {
                $iar_item = IarItem::query()->find($allocatedItem->iar_item_id);
               
                $iar_current_qty = $iar_item->current_qty + $allocatedItem->approved_qty;
                $unaccommodated = 0;

                if ($request['request_qty'] >= $iar_current_qty) {
                    $request['approved_qty'] = $iar_current_qty;
                    $unaccommodated = abs($iar_current_qty - $request['request_qty']);
                    $iar_item->update([
                        'current_qty' => 0, 
                        'issued_qty' => $iar_item->issued_qty + $iar_item->current_qty]);
                }
                else {
                    $iar_item->update([
                        'current_qty' => $iar_item->current_qty + ($allocatedItem->approved_qty - $request['request_qty']),
                        'issued_qty' => $iar_item->issued_qty + ($allocatedItem->approved_qty - $request['request_qty'])
                    ]);
                }
            }

            $allocatedItem->update($request);
            DB::commit();
            return ['message' => 'Allocated Item has been successfully updated'.($unaccommodated > 0) ? ', with a total of '.$unaccommodated.' unaccommodated quantity!' : '!'];
        } catch (Exception $exception) {
            return ['error' => $exception->getMessage()];
        }
    }

    public function destroy($allocatedItem)
    {
        if ($allocatedItem->issuance_status = 'issued') {
            return ['error' => 'Request Denied, this record cannot be deleted since it has been issued!'];
        }

        try {
            $iar_item = IarItem::query()->find($allocatedItem->iar_item_id);
            $iar_item->update([
                'current_qty' =>($iar_item->current_qty + $allocatedItem->approved_qty),
                'issued_qty' => ($iar_item->issued_qty - $allocatedItem->approved_qty)
            ]);
            $allocatedItem->delete();
        } catch (Exception $exception) {
            return ['error' => $exception->getMessage()];
        }
    }
}
