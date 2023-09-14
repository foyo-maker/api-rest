<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

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


    public function authenticateEmail(Request $request)
    {

        $data = $request->all();
        $user = User::where('email', $data['email'])->first();

        // $user will be null if no user with that email is found
        if ($user) {
            $token = Str::random(64);
            DB::table('password_resets')->insert([
    
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now(),
    
            ]);
    
    
            $code = mt_rand(1000, 9999); // Generates a random 4-digit number


            
            $body = "We are received a request to reset the password for HealthyLife+ associated
                    with " . $request->email . " . You Can Use The Below Code To Reset Your Password ";
            Mail::send('email-forget', ['body' => $body, 'code' => $code], function ($message) use ($request) {
    
                $message->from('noreply@gmail.com', 'HealthyLife+');
                $message->to($request->email, 'HealthyLife+')
                    ->subject('Reset Password');
            });

            $userData = [
                'code' =>  $code,
                'email' => $user->email,
               
    
            ];

            return $userData;
            // User with email found, you can access its attributes like $user->name, $user->id, etc.
        } else {
            return response(['message' => 'Email Not Found'], 404);
        }



        return $user;
    }
    

    public function resetPassword(Request $request)
    {


        $data =  $request->validate([
            'email' => 'required',
            'password' => 'required', // Adjust the validation rules as needed
        ]);

        // Find the user by user_id
        $user = User::where('email', $data['email'])->first();

        // Check if the user exists
        if (!$user) {
            return response(['message' => 'Email not found'], 404);
        }

        // Update the user's password
        $user->password = bcrypt($request->input('password'));
        $user->save();

        return $user;
    }
    public function updatePassword(Request $request, $user_id)
    {
        // Validate the request
        $request->validate([
            'currentPass' => 'required',
            'newPass' => 'required', // Adjust the validation rules as needed
        ]);

        // Find the user by user_id
        $user = User::find($user_id);

        // Check if the user exists
        if (!$user) {
            return response(['message' => 'User not found'], 404);
        }

        // Check if the provided current password matches the stored password
        if (!Hash::check($request->input('currentPass'), $user->password)) {
            return response(['message' => 'Invalid Current Password'], 401);
        }

        // Update the user's password
        $user->password = bcrypt($request->input('newPass'));
        $user->save();

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
