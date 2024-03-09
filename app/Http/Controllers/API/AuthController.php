<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validator;
use App\Models\User;

class AuthController extends Controller
{
    //
    public function register(Request $request){
        $validator = Validator::make($request->all(),[
            'name'=> 'required',
            'email'=> ' required|email',
            'contact'=> 'required',
            'password'=> 'required',
            'c_password'=>'required|same:password'
        ]);

        if($validator->fails()){
            $response=[
                'success' => false,
                'message' => $validator->errors()

            ];
            return response()->json($response,400);
        }

        $input =$request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        $success['token'] = $user->createToken('MyApp')->plainTextToken;

        $response = [
            'success' => true,
            'data'=>$success,
            'message'=> 'User Registered Successfully'
        ];

        return response()->json($response,200);
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
