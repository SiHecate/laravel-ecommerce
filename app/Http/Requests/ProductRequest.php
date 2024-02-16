<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:40'],
            'description' => 'nullable|string',
            'image' => ['required', 'string', 'max:40'],
            'price' => ['required', 'numeric', 'between:0.01,999999.99'],
            'stock' => ['required', 'numeric'],
            'visibility' => 'nullable',
            'tag' => ['required', 'string', 'max:40'],
        ];


        // return [
        //     'title' => ['required', 'string', 'max:40'],
        //     'description' => 'nullable|string',
        //     'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        //     'price' => ['required', 'numeric', 'between:0.01,999999.99'],
        //     'stock' => ['required', 'numeric'],
        //     'visibility' => 'nullable',
        //     'tag' => ['required', 'string', 'max:40'],
        // ];
    }
}
