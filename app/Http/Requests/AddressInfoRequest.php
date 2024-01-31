<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressInfoRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'address_name' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'telephone' => ['required', 'string', 'max:20'],
            'city' => ['required', 'string', 'max:255'],
            'county' => ['required', 'string', 'max:255'],
            'neighborhood' => ['required', 'string', 'max:255'],
            'full_address' => ['required', 'string', 'max:255'],
        ];
    }
}
