<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TicketRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['string', 'max:40'],
            'desc' =>  ['string', 'max:520'],
            'response_id' => ['int'],
        ];
    }
}
