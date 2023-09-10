<?php

namespace App\Http\Controllers;

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
        $user = User::create($data);
    
        return $user;
    }

    public function login(Request $request)
    {
        $credentials = $request->validated();
        if (!Auth::attempt($credentials)) {
            return response([
                'message' => 'Provided email or password is incorrect'
            ], 401);
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();
       
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
