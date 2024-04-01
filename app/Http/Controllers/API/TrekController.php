<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validator;
use App\Models\Trek;
use App\Models\TrekImage;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class TrekController extends Controller
{
    public function getTrekDetails(Request $request){
        $search = $request->query('search');
    
        $query = Trek::where('approve', 1)->with('trek_image');
    
        if($search) {
            $query->where('name', 'like', '%'.$search.'%')
                  ->orWhere('description', 'like', '%'.$search.'%');
        }
    
        $treks = $query->paginate(10);
    
        return response()->json(['success' => true, 'data' => $treks], 200);
    }
    
    public function addTrek(Request $request){
        try{
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
            'images' => 'required|array',
            'images.*' => 'mimes:png,jpg,jpeg',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()], 400);
        }

        $input = $request->all();
        $imageName = Str::random(32) . "." . $request->file('map_url')->getClientOriginalExtension();
        $input['map_url'] = $imageName;

        $newTrek = Trek::create($input);
        $trekId = $newTrek->trek_id;

        Storage::disk('public')->put($imageName, file_get_contents($request->map_url));

        $images = [];
        foreach($request->file('images') as $image){
            $trekImageName = Str::random(32) . "." .$image->getClientOriginalExtension();
            Storage::disk('public')->put($trekImageName, file_get_contents($image));
            $images[] = [
                'trek_id' => $trekId,
                'trek_image_name' => $trekImageName,
                'trek_image_path' => asset('storage/app/public/'.$trekImageName)
            ];
        }

        TrekImage::insert($images);

        $response = [
            'success' => true,
            'data' => $newTrek,
            'path' => asset('storage/app/public/'.$imageName),
            'images'=> $images,
            'message' => 'Trek Added Successfully'
        ];

        return response()->json($response, 200);
    } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Exceded File Upload Size, Reduce Image Size.'], 400);
       
    }
}
}