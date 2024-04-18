<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Restaurant; 
use App\Models\TravelAgency; 
use App\Http\Controllers\Controller;
use App\Models\RestaurantEvent;
use App\Models\TravelEvents;
use Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function getVerifiedRestaurant(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer', 
        ]);

        $restaurant = Restaurant::where('added_by', $request->user_id)
        ->whereNotNull('pan')->where('approve',1)->get();
        

        if ($restaurant) {
            return response()->json([
                'success' => true,
                'data' => $restaurant,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Restaurant not found for the specified user ID.',
            ], 404);
        }
    }

    public function getVerifiedAgency(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer', 
        ]);

        $agency = TravelAgency::where('added_by', $request->user_id)
        ->where('approve',1)->get();
        

        if ($agency) {
            return response()->json([
                'success' => true,
                'data' => $agency,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Agency not found for the specified user ID.',
            ], 404);
        }
    }


    public function addRestaurantEvent(Request $request){
        $validator = Validator::make($request->all(), [
            'start_time' => 'required',
            'end_time' => 'required',
            'title' => 'required|string|max:255',
            'body' => 'required|string|max:255',
            'event_image_path' => 'required|mimes:png,jpg,jpeg',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()], 400);
        }
        $input = $request->all();
        $imageName = Str::random(32) . "." . $request->file('event_image_path')->getClientOriginalExtension();
        $input['event_image_path'] = asset('storage/app/public/'.$imageName);
        
        Storage::disk('public')->put($imageName, file_get_contents($request->event_image_path));

        $newRestaurantEvent = RestaurantEvent::create($input);

        $response = [
            'success' => true,
            'data' => $newRestaurantEvent,
            'message' => 'Restaurant Event Added Successfully'
        ];
        return response()->json($response, 200);
    }

    public function addTravelEvent(Request $request){
        $validator = Validator::make($request->all(), [
            'start_time' => 'required',
            'end_time' => 'required',
            'title' => 'required|string|max:255',
            'body' => 'required|string|max:255',
            'event_image_path' => 'required|mimes:png,jpg,jpeg',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()], 400);
        }
        $input = $request->all();
        $imageName = Str::random(32) . "." . $request->file('event_image_path')->getClientOriginalExtension();
        $input['event_image_path'] = asset('storage/app/public/'.$imageName);
        
        Storage::disk('public')->put($imageName, file_get_contents($request->event_image_path));

        $newTravelEvent = TravelEvents::create($input);

        $response = [
            'success' => true,
            'data' => $newTravelEvent,
            'message' => 'Restaurant Event Added Successfully'
        ];
        return response()->json($response, 200);
    }


    public function getRestaurantEvents()
        {
            $currentTime = now();

            $restaurantEvents = RestaurantEvent::where('end_time', '>', $currentTime)
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json(['success' => true, 'data' => $restaurantEvents], 200);
        }
        
    public function getTravelEvents()
        {
            $currentTime = now();

            $restaurantEvents = TravelEvents::where('end_time', '>', $currentTime)
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json(['success' => true, 'data' => $restaurantEvents], 200);
        }

}
