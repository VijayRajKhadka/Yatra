<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Auth;
use Validator;
use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\RestaurantImage;
use App\Models\RestaurantFeedback;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class RestaurantController extends Controller
{
    public function getRestaurantByID(Request $request)
    {
        $restaurant_id = $request->query('restaurant');
        
        $restaurant = Restaurant::with('restaurant_image')
                    ->find($restaurant_id);

        if($restaurant){
            return response()->json(['success' => true, 'data' => $restaurant], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'Place not found'], 404);
        }
    }

    public function getRestaurantDetails(Request $request){
        $search = $request->query('search');
    
        $query = Restaurant::select(
            'restaurant.restaurant_id',
            'restaurant.name',
            'restaurant.description',
            'restaurant.location',
            'restaurant.category',
            'restaurant.created_at',
            DB::raw('IFNULL(AVG(rf.rating), 1) as avg_rating')
        )
        ->leftJoin('restaurant_feedback as rf', 'restaurant.restaurant_id', '=', 'rf.restaurant_id')
        ->with('restaurant_image')
        ->where('restaurant.approve', 1)
        ->groupBy('restaurant.restaurant_id', 'restaurant.name', 'restaurant.description', 'restaurant.location', 'restaurant.category', 'restaurant.created_at')
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

    public function getPlaceReview(Request $request){
        $restrauntID = $request->input('place');
        $reviews = RestaurantFeedback::with('user:id,name,profile_url')
            ->where('restaurant_id', $restrauntID)
            ->whereNotNull('review')
            ->paginate(7);

        if($reviews){
        return response()->json(['success' => true, 'data' => $reviews], 200);
        } else {
        return response()->json(['success' => false, 'message' => 'Review not found'], 404);
        }
    }

    public function getRestaurantReview(Request $request){
        $restaurantId = $request->input('restaurant');
        $reviews = RestaurantFeedback::with('user:id,name,profile_url')
            ->where('restaurant_id', $restaurantId)
            ->whereNotNull('review')
            ->paginate(7);

        if($reviews){
        return response()->json(['success' => true, 'data' => $reviews], 200);
        } else {
        return response()->json(['success' => false, 'message' => 'Review not found'], 404);
        }
    }

    public function addRestaurantFeedback(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'restaurant_id' => 'required',
            'review' => 'required_without:rating',
            'rating' => 'required_without:review',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()], 400);
        }
        $input = $request->all();

        $newRestaurantFeedback = RestaurantFeedback::create($input);

        $response = [
            'success' => true,
            'data' => $newRestaurantFeedback,
            'message' => 'Place Feedback Added Successfully'
        ];
        return response()->json($response, 200);
    }

    public function addRestaurant(Request $request){
        try{
        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'description'=>'required',
            'location'=>'required',
            'category'=>'required',
            'open_time'=>'required',
            'latitude'=>'sometimes',
            'longitude'=>'sometimes',
            'get_there'=>'required',
            'affordability'=> 'required',
            'pan' => 'sometimes',
            'images' => 'required|array',
            'images.*' => 'mimes:png,jpg,jpeg',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()], 400);
        }

        $input = $request->all();

        $newRestaurant = Restaurant::create($input);

        // Change this line to access the correct primary key attribute
        $restaurantId = $newRestaurant->id;
        

        $images = [];
        foreach($request->file('images') as $image){
            $restaurantImageName = Str::random(32) . "." .$image->getClientOriginalExtension();
            Storage::disk('public')->put($restaurantImageName, file_get_contents($image));
            $images[] = [
                'restaurant_id' => $restaurantId,
                'restaurant_image_name' => $restaurantImageName,
                'restaurant_image_path' => asset('storage/app/public/'.$restaurantImageName)
            ];
        }

        RestaurantImage::insert($images);

        $response = [
            'success' => true,
            'data' => $newRestaurant,
            'path' => asset('storage/app/public/'.$restaurantImageName),
            'images'=> $images,
            'message' => 'Restaurant Added Successfully'
        ];

        return response()->json($response, 200);
    } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Exceded File Upload Size, Reduce Image Size.'], 400);
       
    }
}
}
