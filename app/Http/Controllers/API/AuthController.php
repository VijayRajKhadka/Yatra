<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MailController;
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
            'confirm_password'=>'required|same:password'
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


        $response = [
            'success' => true,
            'data' => $user,
            'message'=> 'User Registered Successfully'
        ];

        $mailController = new MailController();
        $mailController->index($input['email'],$input['name']);
        
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
