<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserInfoRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'adress_name' => ['required', 'string', 'max:255'],
            'user_id' => ['required', 'integer'], // varsayılan olarak belirli bir kullanıcıya ait olması gerektiğini varsayalım
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'telephone' => ['required', 'numeric'], // telefon numarası olarak numeric kabul edilir
            'city' => ['required', 'string', 'max:255'],
            'district' => ['required', 'string', 'max:255'],
            'neighborhood' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
        ];
    }
}
