<?php

namespace App\Http\Controllers\Store\Location;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store\Location\LocationCreateRequest;
use App\Http\Requests\Store\Location\LocationQueueRequest;
use App\Http\Requests\Store\Location\LocationStoreRequest;
use App\Http\Requests\Store\Location\LocationStoreUpdateRequest;
use App\Models\Store\Location\Location;
use App\Models\Store\Store;
use App\Services\Store\Location\LocationService;
use App\Http\Requests\Store\Location\LocationCheckinRequest;

/**
 * Class LocationController
 * @package App\Http\Controllers\Store
 */
class LocationController extends Controller
{
    /**
     * @var LocationService
     */
    protected $location;

    /**
     * LocationController constructor.
     * @param LocationService $location
     */
    public function __construct(LocationService $location)
    {
        $this->location = $location;
    }

    /**
     * @param Location $location
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function public(Location $location)
    {
        return view('stores.location.public')
            ->with('location', $location);
    }

    /**
     * @param LocationCreateRequest $request
     * @param string $storeUuid
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(LocationCreateRequest $request, string $storeUuid)
    {
        return view('stores.location.create')
            ->with('store', $storeUuid);
    }

    /**
     * @param LocationStoreRequest $request
     * @param string $storeUuid
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LocationStoreRequest $request, string $storeUuid): \Illuminate\Http\RedirectResponse
    {
        $this->location->create([
            'location_name' => $request->location_name,
            'shopper_limit' => $request->shopper_limit,
            'store_id' => $storeUuid
        ]);

        return redirect()->route('store.store', ['store' => $storeUuid]);
    }

    /**
     * @param LocationQueueRequest $request
     * @param string $storeUuid
     * @param string $locationUuid
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function queue(LocationQueueRequest $request, string $storeUuid, string $locationUuid)
    {
        $location = $this->location->show(
            [
                'uuid' => $locationUuid
            ],
            [
                'Shoppers',
                'Shoppers.Status'
            ]
        );

        $shoppers = null;

        if (isset($location['shoppers']) && count($location['shoppers']) >= 1) {
            $shoppers = $this->location->getShoppers($location['shoppers']);
        }

        return view('stores.location.queue')
            ->with('location', $location)
            ->with('shoppers', $shoppers)
            ->with('storeUuid', $storeUuid);
    }

    /**
     * @param string $locationUuid
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(string $locationUuid, string $storeUuid)
    {
        return view('stores.location.edit')
            ->with('location', $locationUuid)
            ->with('store', $storeUuid);
    }

    /**
     * @param LocationStoreRequest $request
     * @param string $storeUuid
     * @return \Illuminate\Http\RedirectResponse
     */
    public function editLimit(LocationStoreUpdateRequest $request, string $locationUuid, string $storeUuid): \Illuminate\Http\RedirectResponse
    {
        $limit = Location::where('uuid', $locationUuid);
        $limit->update(['shopper_limit' => $request->shopper_limit]);

        return redirect()->route('store.store', ['store' => $storeUuid]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function createLocationCheckin()
    {
        $stores = Store::with('locations')->get();
        return view('location-checkin')
            ->with('stores', $stores);
    }


    /**
     * @param LocationCreateRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function locationCheckin(LocationCheckinRequest $request)
    {
        $location = Location::find($request->location_id);
        return view('stores.location.customer-checkin')
            ->with('location', $location);
    }

    /**
     * @param string $locationId
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function locationCustomerCheckin($locationId)
    {
        $location = Location::find($locationId);
        return view('stores.location.customer-checkin')
            ->with('location', $location);
    }
}
