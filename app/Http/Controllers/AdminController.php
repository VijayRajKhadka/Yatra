<?php

namespace App\Http\Controllers;
use App\Models\Trek;
use App\Models\Place;
use App\Models\Restaurant;


use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function treks($approve)
{
    if ($approve === '0') {
        $treks = Trek::where('approve', 0)->paginate(10);
    } elseif ($approve === '1') {
        $treks = Trek::where('approve', 1)->paginate(10);
    } else {
        $treks = Trek::paginate(10);
    }
    return view('admin.trek', compact('treks'));
}



    public function searchTrek(Request $request)
{
    $query = $request->input('query');
    $treks = Trek::where('name', 'like', '%' . $query . '%')
                    ->orWhere('location', 'like', '%' . $query . '%')
                    ->orWhere('altitude', 'like', '%' . $query . '%')
                    ->orWhere('no_of_days', 'like', '%' . $query . '%')
                    ->paginate(10);

    return view('admin.trek', compact('treks'));
}


    public function getTrekDetails($trek_id)
    {  
        $treks = Trek::findOrFail($trek_id);

        $trekImage = Trek::with('trek_image')->find($trek_id);

        return view('admin.trek_details', compact('treks', 'trekImage'));
    }

    public function updateTrekDetails(Request $request, $trek_id)
    {
        $trek = Trek::find($trek_id);
        $trek->name = $request->input('name');
        $trek->description = $request->input('description');
        $trek->location = $request->input('location');
        $trek->category = $request->input('category');
        $trek->altitude = $request->input('altitude');
        $trek->difficulty = $request->input('difficulty');
        $trek->no_of_days = $request->input('no_of_days');
        $trek->emergency_no = $request->input('emergency_no');
        $trek->budgetRange = $request->input('budgetRange');
        $trek->approve = $request->input('approve');
        $trek->update();

        return redirect()->route('adminTrek', $trek_id)->with('success', "Trek {$trek->name} details updated successfully.");
    }


public function place($approve)
{
    if ($approve === '0') {
        $places = Place::where('approve', 0)->paginate(10);
    } elseif ($approve === '1') {
        $places = Place::where('approve', 1)->paginate(10);
    } else {
        $places = Place::paginate(10);
    }
    return view('admin.place', compact('places'));
}



    public function searchPlace(Request $request)
{
    $query = $request->input('query');
    $places = Place::where('name', 'like', '%' . $query . '%')
                    ->orWhere('location', 'like', '%' . $query . '%')
                    ->orWhere('altitude', 'like', '%' . $query . '%')
                    ->orWhere('no_of_days', 'like', '%' . $query . '%')
                    ->paginate(10);

    return view('admin.place', compact('places'));
}


    public function getPlaceDetails($place_id)
    {  
        $place = Place::findOrFail($place_id);

        $placeImage = Place::with('place_image')->find($place);

        return view('admin.place_details', compact('place', 'placeImage'));

    }

    public function updatePlaceDetails(Request $request, $place_id)
{
    $place = Place::find($place_id);
    $place->name = $request->input('name');
    $place->description = $request->input('description');
    $place->location = $request->input('location');
    $place->category = $request->input('category');
    $place->open_time = $request->input('open_time');
    $place->latitude = $request->input('latitude');
    $place->longitude = $request->input('longitude');
    $place->get_there = $request->input('get_there');
    $place->approve = $request->input('approve');
    $place->update();

return redirect()->route('adminPlace', $place_id)->with('success', "Place {$place->name} details updated successfully.");

}

public function restaurant($approve)
{
    if ($approve === '0') {
        $restaurants = Restaurant::where('approve', 0)->paginate(10);
    } elseif ($approve === '1') {
        $restaurants = Restaurant::where('approve', 1)->paginate(10);
    } else {
        $restaurants = Restaurant::paginate(10);
    }
    return view('admin.restaurant', compact('restaurants'));
}

public function searchRestaurant(Request $request)
{
    $query = $request->input('query');
    $restaurants = Restaurant::where('name', 'like', '%' . $query . '%')
                    ->orWhere('location', 'like', '%' . $query . '%')
                    ->orWhere('category', 'like', '%' . $query . '%')
                    ->orWhere('open_time', 'like', '%' . $query . '%')
                    ->paginate(10);

    return view('admin.restaurant', compact('restaurants'));
}

public function getRestaurantDetails($restaurant_id)
{  
    $restaurant = Restaurant::findOrFail($restaurant_id);

    $restaurantImages = Restaurant::with('restaurant_image')->find($restaurant);



    return view('admin.restaurant_details', compact('restaurant', 'restaurantImages'));

}

public function updateRestaurantDetails(Request $request, $restaurant_id)
{
    $restaurant = Restaurant::find($restaurant_id);
    $restaurant->name = $request->input('name');
    $restaurant->description = $request->input('description');
    $restaurant->location = $request->input('location');
    $restaurant->category = $request->input('category');
    $restaurant->affordability = $request->input('affordability');
    $restaurant->open_time = $request->input('open_time');
    $restaurant->latitude = $request->input('latitude');
    $restaurant->longitude = $request->input('longitude');
    $restaurant->get_there = $request->input('get_there');
    $restaurant->approve = $request->input('approve');
    $restaurant->update();

    return redirect()->route('adminRestaurant', $restaurant_id)->with('success', "Restaurant {$restaurant->name} details updated successfully.");
}


}
