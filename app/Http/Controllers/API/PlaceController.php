<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validator;
use App\Models\Place;
use App\Models\PlaceImage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PlaceController extends Controller
{
    public function getPlaceDetails(){
        return Place::where('approve', 1)->with('place_image')->get();
    }
    public function addPlace(Request $request){
        try{
        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'description'=>'required',
            'location'=>'required',
            'category'=>'required',
            'open_time'=>'required',
            'latitude'=>'required',
            'longitude'=>'required',
            'get_there'=>'required',
            'images' => 'required|array',
            'images.*' => 'mimes:png,jpg,jpeg',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()], 400);
        }

        $input = $request->all();

        $newPlace = Place::create($input);

        $placeId = $newPlace->place_id;

        $images = [];
        foreach($request->file('images') as $image){
            $placeImageName = Str::random(32) . "." .$image->getClientOriginalExtension();
            Storage::disk('public')->put($placeImageName, file_get_contents($image));
            $images[] = [
                'place_id' => $placeId,
                'place_image_name' => $placeImageName,
                'place_image_path' => asset('storage/app/public/'.$placeImageName)
            ];
        }

        PlaceImage::insert($images);

        $response = [
            'success' => true,
            'data' => $newPlace,
            'path' => asset('storage/app/public/'.$placeImageName),
            'images'=> $images,
            'message' => 'Place Added Successfully'
        ];

        return response()->json($response, 200);
    } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Exceded File Upload Size, Reduce Image Size.'], 400);
       
    }
}
}
