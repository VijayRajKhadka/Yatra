<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\HistoricalPlaceImage;
use App\Models\HistoricalPlace;
use App\Models\Monument;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Validator;


class SuperAdminController extends Controller
{
    
    
    public function users()
    {
        $usersWithRole1 = User::where('role', 1)->paginate(10);
        $usersDescending = User::whereNotNull('role')->whereNotIn('role', [1, 3])->orderBy('role', 'desc')->paginate(10);
        
        return view('super-admin.user', compact('usersWithRole1', 'usersDescending'));
    }

    public function events(){
        return view('super-admin.events');
    }

    public function historicalPlaces(){
        $historicalPlaces = HistoricalPlace::with('historical_place_image')->where('isDeleted', 0)->get();
        return view('super-admin.historical_place', compact('historicalPlaces'));
    }


    public function addHistoricalPlaces(){
        return view('super-admin.add_historical_place');
    }


    public function searchUsers(Request $request)
    {
        $query = $request->input('query');

        $usersWithRole1 = User::where('role', 1)->paginate(10);

        $usersDescending = User::where('name', 'like', "%$query%")
            ->orWhere('email', 'like', "%$query%")
            ->orWhere('contact', 'like', "%$query%")
            ->orderBy('role', 'desc')
            ->paginate(10);

        return view('super-admin.user', compact('usersWithRole1', 'usersDescending'));
    }

    public function editUser($id)
    {  
        $user = User::findOrFail($id);

        return view('super-admin.edit_user', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::find($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->role = $request->input('role');
        $user->contact = $request->input('contact');
        $user->update();

        return redirect()->route('users', $id)->with('success', "User {$user->name} details updated successfully.");
    }
   

    public function deleteUser($id)
    {
        $user = User::find($id);
        $user->role = 3;
        $user->save();

        return redirect()->route('users')->with('success', "User {$user->name} is Deleted Succusfully.");
    }

    public function submitHistPlaceForm(Request $request){
        try {
            $validator = Validator::make($request->all(), [
                'name'=>'required',
                'description'=>'required',
                'location'=>'required',
                'map_url'=>'required|mimes:png,jpg,jpeg',
                'open_time'=>'required',
                'latitude'=>'required',
                'longitude'=>'required',
                'get_there'=>'required',
                'ticket_price'=>'required',
                'contact_no'=>'required',
                'images' => 'required|array',
                'images.*' => 'mimes:png,jpg,jpeg',
            ]);
    
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
    
            $input = $request->all();
    
            $mapImageName = Str::random(32) . "." . $request->file('map_url')->getClientOriginalExtension();
            $mapImagePath = 'storage/app/public/' . $mapImageName;
            Storage::disk('public')->put($mapImageName, file_get_contents($request->map_url));
            $input['map_url'] = asset($mapImagePath);
    
            $historicalPlace = HistoricalPlace::create($input);
            $historicalId = $historicalPlace->historical_place_id;

            $images = [];
            foreach($request->file('images') as $image){
                $imageName = Str::random(32) . "." . $image->getClientOriginalExtension();
                $imagePath = 'storage/app/public/' . $imageName;
                Storage::disk('public')->put($imageName, file_get_contents($image));
                $images[] = [
                    'historical_place_id' => $historicalId,
                    'historical_place_image_name' => $imageName,
                    'historical_place_image_path' => asset($imagePath)
                ];
            }
    
            HistoricalPlaceImage::insert($images);
    
            return redirect()->route('historicalPlaces')->with('success', "Historical Place Added Succusfully.");
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error occurred while adding historical place'], 500);
        }
    }

    public function getHistoricalPlaces($historical_place_id){
        $hists = HistoricalPlace::findOrFail($historical_place_id);
        
        $monu = Monument::where('historical_place_id', $historical_place_id)
               ->where('isDeleted', 0)->get();
        
        $histsImages = HistoricalPlace::with('historical_place_image')->find($historical_place_id);

        return view('super-admin.historical_place_details', compact('hists', 'histsImages', 'monu'));
    }
    
    public function updateHistDetails(Request $request, $historical_place_id)
    {
        $hist = HistoricalPlace::find($historical_place_id);
        $hist->name = $request->input('name');
        $hist->description = $request->input('description');
        $hist->location = $request->input('location');
        $hist->latitude = $request->input('latitude');
        $hist->longitude = $request->input('longitude');
        $hist->open_time = $request->input('open_time');
        $hist->get_there = $request->input('get_there');
        $hist->ticket_price = $request->input('ticket_price');
        $hist->contact_no = $request->input('contact_no');
        $hist->update();

        return redirect()->route('historicalPlaces', $historical_place_id)->with('success', "Historical Place {$hist->name} details updated successfully.");
    }

    public function deleteHistoricalPlace(Request $request, $historical_place_id){
        $hist = HistoricalPlace::find($historical_place_id);
        $hist->isDeleted = 1;
        $hist->save();
        return redirect()->route('historicalPlaces')->with('success', "Historical Place {$hist->name} deleted successfully.");

    }


}
