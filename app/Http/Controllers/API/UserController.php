<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller
{
    public function changePassword(Request $request)
    {   
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'old_password' => 'required',
            'new_password' => [
                'required',
                'min:6',
                'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/',
            ],
            'confirm_password' => 'required|same:new_password',
        ], [
            'new_password.regex' => 'Password should also consist Number, and Special Character',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()], 400);
        }
        
        $input = $request->all();

        $user = User::findOrFail($input['id']);

        if (!Hash::check($input['old_password'], $user->password)) {
            return response()->json(['success' => false, 'message' => 'Old password is incorrect'], 400);
        }

        $newPasswordHash = Hash::make($input['new_password']);

        $user->update([
            'password' => $newPasswordHash,
        ]);

        return response()->json(['message' => 'Password changed successfully'], 200);
    }


    public function updateProfilePic(Request $request){

        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'new_profile' => 'required|mimes:png,jpg,jpeg',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()], 400);
        }

        $input = $request->all();

        $user = User::findOrFail($input['id']);

        $imageName = Str::random(32) . "." . $request->file('new_profile')->getClientOriginalExtension();
        $input['new_profile'] = $imageName;
        
        Storage::delete('storage/app/public/'. $user->profile);
        
        Storage::disk('public')->put($imageName, file_get_contents($request->new_profile));

        $user->update([
            'profile' => $imageName,
            'profile_url' => asset('storage/app/public/' . $imageName),
        ]);

        $response = [
            'success' => true,
            'data' => $user,
            'message' => 'User Profile Image Changed Successfully'
        ];
        return response()->json($response, 200);

    }
}
