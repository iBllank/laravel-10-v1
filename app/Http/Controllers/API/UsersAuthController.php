<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsersAuthController extends Controller
{

    public function userLogin(Request $request)
    {
        $rules = [
            'email' => 'required|email|exists:users',
            'password' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails())
            return $this->returnJson(0,'Validation error',null,$validator->errors());

        if(!Auth::attempt($request->only(['email', 'password'])))
            return $this->returnJson(0,'Auth Failure');

        $getUser = User::where('email',$request->get('email'))->first();
        $getUser->token = $getUser->createToken("API-TOKEN")->plainTextToken;
        return $this->returnJson(1,'Login success',$getUser);
    }


    public function userRevokeCurrentToken(Request $request){
        $request->user()->currentAccessToken()->delete();
        return $this->returnJson(1,'Token revoked');
    }



}
