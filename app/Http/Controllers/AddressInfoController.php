<?php

namespace App\Http\Controllers;

use App\Models\AddressInfo;
use Illuminate\Http\Request;

class AddressInfoController extends Controller
{
    protected function validationRules()
    {
        return [
            'address_name' => ['required'],
            'user_id' => ['required', 'numeric'],
            'name' => ['required'],
            'lastname' => ['required'],
            'telephone' => ['required'],
            'city' => ['required'],
            'county' => ['required'],
            'neighborhood' => ['required'],
            'full_address' => ['required'],
        ];
    }

    public function index()
    {
        $addressInfo = AddressInfo::all();
        return response()->json(['addressInfo' => $addressInfo], 200);
    }

    public function store(Request $request)
    {

    }
}
