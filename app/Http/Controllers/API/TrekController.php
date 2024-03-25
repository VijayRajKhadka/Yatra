<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validator;
use App\Models\Trek;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class TrekController extends Controller
{
    public function addTrek(Request $request){

        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'description'=>'required',
            'location'=>'required',
            'category'=>'required',
            'altitude'=>'required',
            'difficulty'=>'required',
            'no_of_days'=>'required',
            'emergency_no'=>'required',
            'map_url'=>'required|mimes:png,jpg,jpeg',
            'budgetRange'=>'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()], 400);
        }

        $input = $request->all();
        $imageName = Str::random(32) . "." . $request->file('map_url')->getClientOriginalExtension();
        $input['map_url'] = $imageName;

        $user = Trek::create($input);
        
        Storage::disk('public')->put($imageName, file_get_contents($request->map_url));


        $response = [
            'success' => true,
            'data' => $user,
            'path' => asset('storage/'.$imageName),
            'message' => 'Trek Added Successfully'
        ];

        return response()->json($response, 200);
    }
}
