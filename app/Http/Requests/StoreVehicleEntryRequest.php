<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVehicleEntryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'job_order_no'   => ['nullable', 'string', 'max:50'],
            'entry_date'     => ['required', 'date'],
            'customer_name'  => ['required', 'string', 'max:150'],
            'phone_number'   => ['nullable', 'string', 'max:30'],
            'car_model'      => ['nullable', 'string', 'max:100'],
            'plate_number'   => ['nullable', 'string', 'max:30'],
            'sma'            => ['nullable', 'string', 'max:100'],

            // At least one real service row is required; add-ons are optional.
            'services'                 => ['required', 'array', 'min:1'],
            'services.*.name_en'      => ['required', 'string', 'max:150'],
            'services.*.name_ar'      => ['nullable', 'string', 'max:150'],
            'services.*.price'        => ['required', 'numeric', 'min:0'],
            'services.*.remarks'      => ['nullable', 'string', 'max:255'],

            'addons'                   => ['sometimes', 'array'],
            'addons.*.name_en'        => ['required_with:addons', 'string', 'max:150'],
            'addons.*.name_ar'        => ['nullable', 'string', 'max:150'],
            'addons.*.price'          => ['required_with:addons', 'numeric', 'min:0'],
            'addons.*.remarks'        => ['nullable', 'string', 'max:255'],

            'customer_signature' => ['required', 'string', 'starts_with:data:image/'],
            'manager_signature'  => ['nullable', 'string', 'starts_with:data:image/'],
        ];
    }

    public function messages(): array
    {
        return [
            'customer_signature.required' => 'Customer signature is required before submitting.',
            'services.required'           => 'Add at least one service row before submitting.',
        ];
    }
}
