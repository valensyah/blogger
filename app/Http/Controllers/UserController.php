<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UserController extends Controller
{
    public function index() {
        return view('pages.author.profile');
    }
    
    public function updateProfile(Request $req) {
        $fileName = '';
        if ($req->hasFile('avatar')) {
            $file = $req->file('avatar');
            // Get the original file name
            $fileName = Carbon::now()->format('Y-m-d_HH:mm').'_'.Auth::user()->id;
            
            // Move the file to a public directory (e.g., storage/app/public)
            $file->storeAs('public/images/avatar', $fileName);
        }
    }
}
