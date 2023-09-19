<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\BlogComment;
use App\Models\News;

class HomeController extends Controller
{
    public function index() {
        $news = News::with('category')->get();
        return view('pages.home', compact('news'));
    }
    
    public function sendComment() {
        $message = 'This is a test notification.';
        event(new BlogComment('hallo'));
        return view('home');
    }
}
