<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserStoreRequest;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return UserResource::collection(User::paginate(10));
        // return $this->returnJson(1,__('messages.success'),$users);
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
        $newUser = new UserResource($newUser);
        return $this->returnJson(1,__('messages.success'),$newUser);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user = new UserResource($user);
        return $this->returnJson(1,__('messages.success'),$user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //left as a refrence
        $request->validate([
            'name' => 'required|max:255',
        ]);
        //end of refrence

        $user->name = $request->get('name');
        $user->save();
        $user = new UserResource($user);
        return $this->returnJson(1,__('messages.success'),$user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $delUser = $user->delete();
        return $this->returnJson(1,__('messages.success'));
    }
}
