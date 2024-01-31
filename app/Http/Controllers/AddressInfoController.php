<?php

namespace App\Http\Controllers;

use App\Models\AddressInfo;
use Illuminate\Http\Request;
use App\Http\Requests\AddressInfoRequest;

class AddressInfoController extends Controller
{

    public function index()
    {
        $addressInfo = AddressInfo::all();
        return response()->json(['addressInfo' => $addressInfo], 200);
    }

    public function store(AddressInfoRequest $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }

        $user_id = $user->id;
        $addressName = $request->input('address_name');

        $existingAddress = AddressInfo::where('user_id', $user_id)
            ->where('address_name', $addressName)
            ->first();

        if ($existingAddress) {
            return response()->json(['message' => $addressName . ' already exists for this user.'], 400);
        }

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

        return response()->json(['message' => 'New address created successfully', 'addressInfo' => $addressInfo], 201);
    }



    public function update($address_id, Request $request)
    {
        //later
    }

    public function destroy($address_id, Request $request)
    {
        $user_id = $request->user()->id;
        $addressInfo = AddressInfo::where('user_id', $user_id)->first();
        $address_id = $addressInfo->id;

        if($address_id){
            $addresInfo = AddressInfo::findOrFail($address_id);
            $addresInfo->delete();

            return response()->json(['message' => 'Address deleted succesfully', 'deleted_address' => $addressInfo], 200);
        } else
        {
            return response()->json(['message' => 'Address can not found'], 404);
        }
    }

    /*
        Gösterilecek olan bilgiler:
            - adres adı
            - adres sahibi adları
            - adres sahibi telefon numarası
            - adres ? ofc
            - 4	Home2	1	John	Doe	1234567890	Example City	Example County	Example Neighborhood	123 Example Street	2024-01-15 00:46:43	2024-01-15 00:46:43
    */
    public function view(Request $request)
    {
        $user_id = $request->user()->id;

        $addressInfos = AddressInfo::where('user_id', $user_id)->get();

        $addresses = [];

        foreach ($addressInfos as $address) {
            $addresses[] = [
                'id' => $address->id,
                'user_id' => $address->user_id,
                'name' => $address->name,
                'lastname' => $address->lastname,
                'telephone' => $address->telephone,
                'city' => $address->city,
                'county' => $address->county,
                'neighborhood' => $address->neighborhood,
                'full_address' => $address->full_address,
            ];
        }
        return response()->json(['addresses' => $addresses], 200);
    }
}