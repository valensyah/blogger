<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->stateless()->user();
        $userExist = User::where('email', $user->email)->first();
        // dd($user);
        if($userExist) {
            Auth::login($userExist);
        } else {
            $newUser = new User;
            $newUser->name = $user->name;
            $newUser->email = $user->email;
            $newUser->avatar = $user->avatar; // Add any additional fields you want to save

            $newUser->save();

            // Log in the new user
            Auth::login($newUser);

        }
        return redirect('/');
        // You can now handle the user data as needed
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->back();
    }

}
