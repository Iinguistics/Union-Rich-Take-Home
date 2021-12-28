<?php

namespace App\Http\Requests\Store\Location;

use App\Models\Store\Location\Location;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class LocationStoreRequest
 * @package App\Http\Requests\Store\Location
 */
class LocationCustomerCheckinRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'location_id' => 'required|integer|max:20',
            'first_name' => 'required|string|max:150',
            'last_name' => 'required|string|max:150',
            'email' => 'required|string|max:150'
        ];
    }
}
