<?php

namespace App\Http\Requests\Store\Location;

use App\Models\Store\Location\Location;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class LocationStoreRequest
 * @package App\Http\Requests\Store\Location
 */
class LocationCheckinRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'store_id' => 'required|integer|max:20',
            'location_id' => 'required|integer|max:20'
        ];
    }
}
