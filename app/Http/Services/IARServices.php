<?php

namespace App\Http\Services;

use App\Models\Iar;
use App\Models\IarItem;
use App\Repository\IARRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IARServices
{
    public function store($request)
    {
        try {
            $request['iar_number'] = $this->generateIARNum();
            $request['logistics_officer'] = Auth::user()->given_name;
            
            return Iar::query()
            ->create($request);
        } catch (Exception $exception) {
            return ['error' => $exception->getMessage()];
        }
    }

    public function update($iar, $request)
    {
        try {
            $iar->update($request);
            return $iar;
        } catch (Exception $exception) {
            return ['error' => $exception->getMessage()];
        }
    }

    public function destroy($iar)
    {
        try {
            $iar->delete();
        } catch (Exception $exception) {
            return ['error' => $exception->getMessage()];
        }
    }

    public function createItemsFromPO($iar_id, $items)
    {
        DB::beginTransaction();
        try {
            foreach ($items as $item) {
                IarItem::query()
                ->create([
                    'beginning_qty' => $item['qty'],
                    'current_qty' => $item['qty'],
                    'iar_id' => $iar_id,
                    'item_id' => $item['id'],
                    'receiving_office' => $item['receiving_office'],
                    // 'expiration_date' => (! empty($item['expiration_date'])) ? $item['expiration_date'] : null
                ]);
            }
        } catch (Exception $exception) {
            return ['error' => $exception->getMessage()];
        }
    }

    public function generateIARNum()
    {
        $iarRepository = new IARRepository();
        $stringServices = new StringServices();

        $currentIarNum = $iarRepository->getCurrentIARNum();

        if (empty($currentIarNum)) {
            $iarNum = 'IAR'.Carbon::now()->year.'-'.$stringServices->threeCodeFormat(Carbon::now()->month).'-'.'00001';
        }
        else {
            list(,,$increment) = explode('-', $currentIarNum);
            $iarNum = 'IAR'.Carbon::now()->year.'-'.$stringServices->threeCodeFormat(Carbon::now()->month).'-'.$stringServices->fiveCodeFormat(intval($increment)+1);
        }

        return $iarNum;
    }

}
