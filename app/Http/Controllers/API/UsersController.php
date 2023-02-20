<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = User::all();
        return $this->returnJson(1,'Request successful',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => [
                'required',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()
            ],
            'password_confirmation' => 'required|same:password'
          ];

          $validator = Validator::make($request->all(), $rules);
          if($validator->fails())
                return $this->returnJson(0,'Validation error',null,$validator->errors());


          $newUser = new User([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
          ]);

          $newUser->save();

          return $this->returnJson(1,'Request successful',$newUser);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);
        if(!$user)
            return $this->returnJson(0,'User not found');
        return $this->returnJson(1,'Request successful',$user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);
        if(!$user)
            return $this->returnJson(0,'User not found');

        $rules = [
          'name' => 'required|max:255',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails())
              return $this->returnJson(0,'Validation error',null,$validator->errors());


        $user->name = $request->get('name');

        $user->save();

        return $this->returnJson(1,'Request successful',$user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        if(!$user)
            return $this->returnJson(0,'User not found');
        $user->delete();
        return $this->returnJson(1,'Request successful',$user::all());
    }


}
