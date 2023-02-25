<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserStoreRequest;
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
        return $this->returnJson(1,__('messages.success'),$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
    {
          $newUser = new User([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
          ]);
          $newUser->save();
          return $this->returnJson(1,__('messages.success'),$newUser);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);
        if(!$user)
            return $this->returnJson(0,__('messages.attr_not_found',['attr'=>__('messages.user')]));
        return $this->returnJson(1,__('messages.success'),$user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);
        if(!$user)
            return $this->returnJson(0,__('messages.attr_not_found',['attr'=>__('messages.user')]));

        //left as a refrence
        $rules = [
          'name' => 'required|max:255',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails())
              return $this->returnJson(0,'Validation error',null,$validator->errors());
        //end of refrence

        $user->name = $request->get('name');
        $user->save();
        return $this->returnJson(1,__('messages.success'),$user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        if(!$user)
            return $this->returnJson(0,__('messages.attr_not_found',['attr'=>__('messages.user')]));
        $user->delete();
        return $this->returnJson(1,__('messages.success'),$user::all());
    }


}
