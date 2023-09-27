<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;


class AuthController extends BaseController
{
    public function Login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        if (Auth::attempt($credentials)) {
            
            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;
            return response()->json(['token' => $token, 'message' => 'success'], 200);
        } else {
            $message = "Failed";
            return $this->sendError($message);
        }
    }
    public function Registration(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            
        ]);
    
         
        if ($validator->fails()) {
              response()->json(['errors' => $validator->errors()->all()], 422);
        }
    
        
        $user = User::firstOrCreate(
            ['email' => $request->input('email')],
            [
                'name' => $request->input('name'),
                'password' => bcrypt($request->input('password')),
            ]
        );
    
        $token = $user->createToken('auth_token')->plainTextToken;
        $data = [
            'user_details' => $user,
            'token' => $token,
        ];
     
        return response()->json(['data' => $data, 'message' => 'Success'], 200);
    }

    public function profile_details(Request $request)
    {
        $user = $request->user();
        return response()->json(['user' => $user]);
    }
    public function logout()
    {
        auth('sanctum')->user()->tokens()->delete();

        //auth()->user()->tokens()->delete();
        return $this->sendResponse([], "Logged Out");
    }
}
