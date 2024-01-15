<?php

namespace App\Http\Controllers;

use App\Models\AddressInfo;
use Illuminate\Http\Request;

class AddressInfoController extends Controller
{
    protected function validationRules()
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

    public function index()
    {
        $addressInfo = AddressInfo::all();
        return response()->json(['addressInfo' => $addressInfo], 200);
    }

    public function store(Request $request)
    {
        $request->validate($this->validationRules());
        $user = $request->user();

        if ($user)
        {
            $user_id = $user->id;
        } else {
            return response()->json(['message' => 'User not authenticated'], 401);
        }

        $addressName = $request->input('address_name');

        $existingAddress = AddressInfo::where('user_id', $user_id)
            ->where('address_name', $addressName)
            ->first();

        if ($existingAddress) {
            return response()->json(['message' => $addressName . ' already exists for this user.'], 400);
        }

        $addressInfo = AddressInfo::where('user_id', $user_id)->first();

        if (!$addressInfo) {
            $addressInfo = AddressInfo::create([
                'user_id' => $user_id,
                'address_name' => $addressName,
                'name' => $request->input('name'),
                'lastname' => $request->input('lastname'),
                'telephone' => $request->input('telephone'),
                'city' => $request->input('city'),
                'county' => $request->input('county'),
                'neighborhood' => $request->input('neighborhood'),
                'full_address' => $request->input('full_address'),
            ]);
        }
        return response()->json(['message' => 'New address create succesfully', 'addressInfo' => $addressInfo], 201);
    }
}
