<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserLoginRequest;

class UsersAuthController extends Controller
{

    public function userLogin(UserLoginRequest $request)
    {
        if(!Auth::attempt($request->only(['email', 'password'])))
            return $this->returnJson(0,__('messages.auth_failed'));

        $getUser = User::where('email',$request->get('email'))->first();
        $getUser->token = $getUser->createToken("API-TOKEN")->plainTextToken;
        return $this->returnJson(1,__('messages.login_success'),$getUser);
    }


    public function userRevokeCurrentToken(Request $request){
        $request->user()->currentAccessToken()->delete();
        return $this->returnJson(1,__('messages.token_revoked'));
    }



}
