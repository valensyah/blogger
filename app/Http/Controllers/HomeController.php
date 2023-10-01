<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\BlogComment;
use App\Models\News;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index() {
        $news = News::with('category', 'user')->get();
        // dd($news);
        return view('pages.home', compact('news'));
    }
    
    public function searchContent(Request $req) {
        $new = News::where('title', 'like', '%'.$req->keyword.'%')
        ->orWhere('title', 'like', '%'.$req->keyword.'%')
        ->with('category')
        ->get();

        return view('pages.find', compact('new'));
    }

    public function about() {
        return view('pages.maintenance');
    }

    public function policy() {
        return view('pages.maintenance');
    }
}
