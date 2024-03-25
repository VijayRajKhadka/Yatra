<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MailController;
use Illuminate\Http\Request;
use Auth;
use Validator;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    //
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'contact' => 'required',
                'profile' => 'required|mimes:png,jpg,jpeg,gif',
                'password' => 'required',
                'confirm_password' => 'required|same:password',
                
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }

            $input = $request->all();
            $input['password'] = bcrypt($input['password']);
            $imageName = Str::random(32) . "." . $request->file('profile')->getClientOriginalExtension();
            $input['profile'] = $imageName;
    
            $user = User::create($input);
            
            Storage::disk('public')->put($imageName, file_get_contents($request->profile));


            $response = [
                'success' => true,
                'data' => $user,
                'message' => 'User Registered Successfully'
            ];

            $mailController = new MailController();
            $mailController->index($input['email'], $input['name']);

            return response()->json($response, 200);
        } catch (QueryException $e) {
            if ($e->errorInfo[1] === 1062) {
                return response()->json(['success' => false, 'message' => 'User with this email already exists'], 400);
            } else {
                return response()->json(['success' => false, 'message' => 'Database error'], 500);
            }
        }
    }

    public function login(Request $request){
        if(Auth::attempt(['email'=>$request->email,'password'=>$request->password])){
            $user = Auth::user();
            $success['token'] = $user->createToken('MyApp')->plainTextToken;
            $success['name']= $user->name;
            $response = [
                'success' => true,
                'data'=>$success,
                'message'=> 'User Logged Successfully'
            ];

            return response()->json($response,200);
        }else{
            $response=[
                'success'=> false,
                'message'=>'Unauthorised'
            ];
            return response()->json($response);
        }
        
    }
}
