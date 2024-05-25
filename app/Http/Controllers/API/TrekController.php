<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validator;
use App\Models\Trek;
use App\Models\TrekImage;
use App\Models\TrekFeedback;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class TrekController extends Controller
{   
    public function getTrekByID(Request $request){
        $trek_id = $request->query('trek');
        $trek = Trek::with('trek_image')
                    ->find($trek_id);
        
        if($trek){
            return response()->json(['success' => true, 'data' => $trek], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'Trek not found'], 404);
        }
    }

    public function getTrekReview(Request $request){
        $placeId = $request->input('trek');
        $reviews = TrekFeedback::with('user:id,name,profile_url')
        ->where('trek_id', $placeId)
        ->whereNotNull('review')
        ->orderBy('created_at', 'desc')
        ->paginate(7);

        if($reviews){
        return response()->json(['success' => true, 'data' => $reviews], 200);
        } else {
        return response()->json(['success' => false, 'message' => 'Review not found'], 404);
        }
    }



    public function addTrekFeedback(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'trek_id' => 'required',
            'review' => 'required_without:rating',
            'rating' => 'required_without:review',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()], 400);
        }

        $input = $request->all();

        $existingFeedback = TrekFeedback::where('user_id', $input['user_id'])
                                        ->where('trek_id', $input['trek_id'])
                                        ->first();

        if ($existingFeedback) {
            return response()->json([
                'success' => false,
                'message' => 'You have already rated this trek.'
            ], 400);
        }

        $newTrekFeedback = TrekFeedback::create($input);

        $response = [
            'success' => true,
            'data' => $newTrekFeedback,
            'message' => 'Trek Feedback Added Successfully'
        ];

        return response()->json($response, 200);
    }



    public function getTrekDetails(Request $request){
        $search = $request->query('search');
    
        $query = Trek::select(
            'trek.trek_id',
            'trek.name',
            'trek.location',
            'trek.category',
            'trek.approve',
            'trek.created_at',
            DB::raw('IFNULL(AVG(tf.rating), 1) as avg_rating')
            )
        ->leftJoin('trek_feedback as tf', 'trek.trek_id', '=', 'tf.trek_id')
        ->with('trek_image')
        ->where('trek.approve', 1)
        ->groupBy('trek.trek_id', 'trek.name', 'trek.description', 'trek.location', 'trek.category', 'trek.altitude', 'trek.difficulty', 'trek.no_of_days', 'trek.emergency_no', 'trek.map_url', 'trek.budgetRange', 'trek.approve', 'trek.created_at', 'trek.updated_at')
        ->orderByDesc('avg_rating');

        if($search) {
            $query->where(function($query) use ($search) {
                $query->where('name', 'like', '%'.$search.'%')
                      ->orWhere('description', 'like', '%'.$search.'%');
            });
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
            'added_by' => 'required',
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
        $input['map_url'] = asset('storage/app/public/'.$imageName);

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