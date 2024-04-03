<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validator;
use App\Models\Place;
use App\Models\PlaceImage;
use App\Models\PlaceFeedback;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class PlaceController extends Controller
{   
    public function getPlaceByID(Request $request)
    {
        $place_id = $request->query('place');
        
        $place = Place::with('place_image')
                    ->find($place_id);

        if($place){
            return response()->json(['success' => true, 'data' => $place], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'Place not found'], 404);
        }
    }

    public function getPlaceReview(Request $request){
        $placeId = $request->input('place');
        $reviews = PlaceFeedback::with('user:id,name,profile_url')
            ->where('place_id', $placeId)
            ->whereNotNull('review')
            ->paginate(7);

        if($reviews){
        return response()->json(['success' => true, 'data' => $reviews], 200);
        } else {
        return response()->json(['success' => false, 'message' => 'Review not found'], 404);
        }
    }

    public function getPlaceDetails(Request $request){
        $search = $request->query('search');
    
        $query = Place::select(
            'place.place_id',
            'place.name',
            'place.description',
            'place.location',
            'place.category',
            'place.created_at',
            DB::raw('IFNULL(AVG(pf.rating), 1) as avg_rating')
        )
        ->leftJoin('place_feedback as pf', 'place.place_id', '=', 'pf.place_id')
        ->with('place_image')
        ->where('place.approve', 1)
        ->groupBy('place.place_id', 'place.name', 'place.description', 'place.location', 'place.category', 'place.created_at')
        ->orderByDesc('avg_rating');
    
        if($search) {
            $query->where(function($query) use ($search) {
                $query->where('name', 'like', '%'.$search.'%')
                      ->orWhere('description', 'like', '%'.$search.'%');
            });
        }
    
        $places = $query->paginate(10);
    
        return response()->json(['success' => true, 'data' => $places], 200);
    }
    
    public function addPlaceFeedback(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'place_id' => 'required',
            'review' => 'required_without:rating',
            'rating' => 'required_without:review',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()], 400);
        }
        $input = $request->all();

        $newPlaceFeedback = PlaceFeedback::create($input);

        $response = [
            'success' => true,
            'data' => $newPlaceFeedback,
            'message' => 'Place Feedback Added Successfully'
        ];
        return response()->json($response, 200);
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
