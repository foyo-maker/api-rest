<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function authenticateUser(Request $request, $id)
    {

        $user = User::find($id);
        return $user;
    }

    public function signup(Request $request)
    {
        $data = $request->all();
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    
        return $user;
    }

    public function login(LoginRequest $request)
    {

        // $credentials = $request->validate();

        // if (auth()->attempt($credentials)) {
        //     //SESSION REGENERATE
        //     session()->regenerate();
        //     $user = Auth::user();
        //     return $user;
            
        // }else{
        //     return response([
        //         'message' => 'Provided email or password is incorrect'
        //     ], 401);
        // }

        $credentials = $request->validated();
        if (!Auth::attempt($credentials)) {
            return response([
                'message' => 'Provided email or password is incorrect'
            ], 401);
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $token = $user->createToken('main')->plainTextToken;
        return $user;
        

    }

    public function logout(Request $request)
    {
        /** @var \App\Models\User $user */


        auth()->logout();
        session()->invalidate();
        session()->regenerateToken();
        return response('', 204);
    }

}
