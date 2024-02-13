<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResponseController extends Controller
{
    public function error()
    {
        return response()->json([
            "success" => "false",
            "message" => "Error",
        ], 400);
    }

    public function success()
    {
        return response()->json([
            "success" => "true",
            "message" => "success"
        ],200);
    }
}
