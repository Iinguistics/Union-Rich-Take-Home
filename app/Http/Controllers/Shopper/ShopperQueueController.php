<?php

namespace App\Http\Controllers\Shopper;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shopper\Shopper;
use App\Models\Store\Location\Location;
use App\Http\Requests\Store\Location\LocationCustomerCheckinRequest;
use Carbon\Carbon;

class ShopperQueueController extends Controller
{

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function checkout(Request $request): \Illuminate\Http\RedirectResponse
    {
        $currentTime = Carbon::now();
        $checkedOutShopper = Shopper::where('uuid', $request->shopperUuid)
            ->update(['status_id' => 2, 'check_out' => $currentTime]);

        $location = Location::where('uuid', $request->locationUuid)->get()->first();

        $activeShoppers = Shopper::where('location_id', $location->id)
            ->where('status_id', 1)->get();

        $pendingShopper = Shopper::where('location_id', $location->id)
            ->where('status_id', 3)->get()->first();

        if (count($activeShoppers) < $location->shopper_limit) {
            $pendingShopper->update(['status_id' => 1]);
        }

        return redirect()->route('store.store', ['store' => $request->storeUuid]);
    }

    /**
     * @param LocationCustomerCheckinRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function queueCustomerCheckin(LocationCustomerCheckinRequest $request): \Illuminate\Http\RedirectResponse
    {
        $currentTime = Carbon::now();
        $status_id = 3;
        $location = Location::find($request->location_id);

        $activeShoppers = Shopper::where('location_id', $request->location_id)
            ->where('status_id', 1)->get();

        if (count($activeShoppers) < $location->shopper_limit) {
            $status_id = 1;
        }

        $newShopper = Shopper::create([
            "location_id" => $location->id,
            "status_id" => $status_id,
            "first_name" => $request->first_name,
            "last_name" => $request->last_name,
            "email" => $request->email,
            "check_in" => $currentTime
        ]);

        return redirect()->route('locationCustomerCheckin', ['locationId' => $location->id])->with('queue-checkin-message', 'You have been added to the queue');
    }
}
