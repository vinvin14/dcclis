<?php

namespace App\Http\Services;

use App\Models\IarItem;
use App\Models\Ics;
use App\Models\Par;
use App\Models\RisItem;
use App\Repository\RisItemRepository;
use Exception;
use Illuminate\Support\Facades\DB;

class RisItemServices
{
    public function store($request)
    {
        $iar_item = IarItem::query()->find($request['iar_item_id']);
        DB::beginTransaction();
        try {

            DB::commit();
            return RisItem::query()
            ->create($request);

        } catch (Exception $exception) {
            DB::rollBack();
            return ['error' => $exception->getMessage()];
        }
    }

    public function update($risItem, $request)
    {
        try {
            $risItem->update($request);
            return $risItem;
        } catch (Exception $exception) {
            return ['error' => $exception->getMessage()];
        }
    }

    public function destroy($risItem)
    {
        try {
            $risItem->delete();
        } catch (Exception $exception) {
            return ['error' => $exception->getMessage()];
        }
    }

    public function approveRequest($risItem, $request)
    {
        try {
            $iar_item = IarItem::query()->find($risItem->iar_item_id);
            
            if ($iar_item->current_qty > $request['approved_qty']) {
                $iar_item_qty = $iar_item->current_qty - $request['approved_qty'];
                
            } else {
                $iar_item_qty = 0;
                $request['approved_qty'] = $iar_item->current_qty;
            }

            $iar_item->update(['current_qty' => $iar_item_qty]);
            $risItem->update($request);
            return $risItem;
        } catch (Exception $exception) {
            return ['error' => $exception->getMessage()];
        }
    }

    public function approveRis($ris_id, $office)
    {
        DB::beginTransaction();
        try {
            $ris_items = (new RisItemRepository())->getApprovedRisItems($ris_id);

            if ( empty($ris_items)) {
                return ['error' => 'No existing RIS Item(s) found!'];
            }
            
            foreach ($ris_items as $ris_item) 
            {
                if ($ris_item->price < 15000) 
                {
                    for ($x = 0; $x<=$ris_item->approved_qty; $x++) {
                            Ics::query()->create(
                                [
                                    'ics_number' => (new IcsServices())->generateIcsNum($office),
                                    'property_number' => (new IcsServices())->generatePropertyNumber($office),
                                    'qty' => 1,
                                    'ris_id' => $ris_id,
                                ]
                            );
                    
                    }
                } 
                else 
                {
                    for ($x = 0; $x<=$ris_item->approved_qty; $x++) {
                        Par::query()->create(
                            [
                                'par_number' => (new ParServices())->generateParNum($office),
                                'property_number' => (new ParServices())->generatePropertyNumber($office),
                                'qty' => 1,
                                'ris_id' => $ris_id,
                            ]
                        );
                        $ics = (new ParServices())->store(
                            [
                                
                                
                            ], $office);
                    }
                }
            }

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            return ['error' => $exception->getMessage()];
        }

    }
}
