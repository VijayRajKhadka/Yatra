<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Monument;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Validator;

class MonumentController extends Controller
{
    public function addMonument(Request $request){
        try{
        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'description'=>'required',
            'historical_place_id'=>'required',
            'monument_imageUrl'=>'required|mimes:png,jpg,jpeg',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $input = $request->all();
        $imageName = Str::random(32) . "." . $request->file('monument_imageUrl')->getClientOriginalExtension();
        $input['monument_imageUrl'] = asset('storage/app/public/'.$imageName);

        $newMoument = Monument::create($input);

        Storage::disk('public')->put($imageName, file_get_contents($request->monument_imageUrl));


        $response = [
            'success' => true,
            'data' => $newMoument,
            'path' => asset('storage/app/public/'.$imageName),
            'message' => 'Trek Added Successfully'
        ];

        return redirect()->route('historicalPlaceDetails', $request->historical_place_id)->with('success', "Monument Place Added Succusfully.");
    } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Exceded File Upload Size, Reduce Image Size.'], 400);
       
    }
}
    public function updateMonument(Request $request, $monuments_id)
    {
        $monu = Monument::find($monuments_id);
        $monu->name = $request->input('name');
        $monu->description = $request->input('description');
        $monu->update();

        return redirect()->route('historicalPlaceDetails', $monu->historical_place_id)->with('success', "Monument {$monu->name} details updated successfully.");
    }

    
    public function deleteMonument(Request $request, $monuments_id){
        $monu = Monument::find($monuments_id);
        $monu->isDeleted = 1;
        $monu->save();
        return redirect()->route('historicalPlaceDetails', $monu->historical_place_id)->with('success', "Monument {$monu->name} deleted successfully.");
    }
}   
