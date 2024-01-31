<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BasketRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'product_id' => ['required','numeric',]
        ];
    }
}
