<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //user register
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' =>'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(!$validator->fails())
        {
            $user = new User();
            $user->name = $request->name;
            $user->email =$request->email;
            $user->password=bcrypt($request->password);
            $user->save();

            return response()->json([
                'status_code'=>200,
                'message' =>'User created successfully!'
            ]);
        }
        else
        {
            return $validator->errors();
        }
    }

    //user login
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required'

        ]);

        if($validator->fails())
        {
            return $validator->errors();
        }

        $credentials = request(['email','password']);

        if(!Auth::attempt($credentials))
        {
            return response()->json([
                'status_code' =>500,
                'message' =>'Unauthorized'
            ]);
        }

        $user = User::where('email',$request->email)->first();

        $tokenResult = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'status_code' =>200,
            'token' =>$tokenResult
        ]);
    }

    //user logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status_code' =>200,
            'message' =>'Token deleted successfull!'
        ]);
    }
}
