<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PracticeController extends Controller
{
    public function index(){
        return response()->json([
            "status" => true,
            "message" => "successfully accessed route",
            "user" => [
                "name" => "Rohan",
                "age" => 18
            ]
        ]);
    }
}
