<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\TravelAgency;
use App\Models\TravelGuide;


class TravelAgencyController extends Controller
{
    public function addTravelAgency(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'name'=>'required',
                'email'=>'required',
                'location'=>'required',
                'contact_no'=>'required',
                'registration_no'=>'required',
                'agency_image_url'=>'required|mimes:png,jpg,jpeg',
                'added_by' => 'required',
                'document_url'=>'required|mimes:png,jpg,jpeg',
            ]);
    
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
    
            $input = $request->all();

            $documentName = Str::random(32) . "." . $request->file('document_url')->getClientOriginalExtension();
            $input['document_url'] = asset('storage/app/public/'.$documentName);
                        
            $imageName = Str::random(32) . "." . $request->file('agency_image_url')->getClientOriginalExtension();
            $input['agency_image_url'] = asset('storage/app/public/'.$imageName);

            $newTravelAgency = TravelAgency::create($input);
                
            Storage::disk('public')->put($documentName, file_get_contents($request->file('document_url')));
            Storage::disk('public')->put($imageName, file_get_contents($request->file('agency_image_url')));


        
            $response = [
                'success' => true,
                'data' => $newTravelAgency,
                'path' => asset('storage/app/public/'.$documentName),
                'path' => asset('storage/app/public/'.$imageName),
                'message' => 'Travel Agency Added Successfully'
            ];
    
            return response()->json($response, 200);
        } catch (Exception $e) {
                return response()->json(['success' => false, 'message' => 'Some Error Occured Try Again Later'], 400);
           
        }
    }

    public function addTravelGuide(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'name'=>'required',
                'contact'=>'required',
                'experience'=>'required',
                'profile_url'=>'required|mimes:png,jpg,jpeg',
                'agency_id' => 'required',
                
            ]);
    
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
    
            $input = $request->all();

    
            $imageName = Str::random(32) . "." . $request->file('profile_url')->getClientOriginalExtension();
            $input['profile_url'] = asset('storage/app/public/'.$imageName);

            $newTravelGuide = TravelGuide::create($input);
                
            Storage::disk('public')->put($imageName, file_get_contents($request->file('profile_url')));

        
            $response = [
                'success' => true,
                'data' => $newTravelGuide,
                'path' => asset('storage/app/public/'.$imageName),
                'message' => 'Travel Agency Added Successfully'
            ];
    
            return response()->json($response, 200);
        } catch (Exception $e) {
                return response()->json(['success' => false, 'message' => 'Some Error Occured Try Again Later'], 400);
        }
    }

    public function getTravelGuide(){

        
        $agency = TravelAgency::with('travel_guides')->get();
                   

        if($agency){
            return response()->json(['success' => true, 'data' => $agency], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'Agency not found'], 404);
        }
    }
    

    public function getAgencyGuide(Request $request){
        $request->validate([
            'agency_id' => 'required|integer', 
        ]);
    
        $guide = TravelGuide::where('agency_id', $request->agency_id)
               ->where('isDeleted', 0)->get();
        
        if($guide->isNotEmpty()){
            return response()->json(['success' => true, 'data' => $guide], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'No guides found'], 404);
        }
    }
    
    
    public function deleteGuideById(Request $request, $guide_id){
        $guide = TravelGuide::find($guide_id);
        if(!$guide){
            return response()->json(['success' => false, 'message'=> 'Guide not found'], 404);
        }
        
        $guide->isDeleted = 1;
        $guide->save();
        
        return response()->json(['success' => true, 'message'=> 'Guide Deleted Successfully'], 200);
    }
    

}
