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
        foreach ($news as $item) {
            $temp = [];
            if ($item->tags) {
                $tag = explode(",", $item->tags);
                foreach ($tag as $t) {
                    $newTag = '#'.$t;
                    array_push($temp, $newTag);
                }
                $item->tags = implode(', ', $temp);
            }
        }
        // dd($news);
        return view('pages.home', compact('news'));
    }
    
    public function searchContent(Request $req) {
        $new = News::where('title', 'like', '%'.$req->keyword.'%')
        ->orWhere('tags', 'like', '%'.$req->keyword.'%')
        ->with('category')
        ->get();

        foreach ($new as $item) {
            $temp = [];
            if ($item->tags) {
                $tag = explode(",", $item->tags);
                foreach ($tag as $t) {
                    $newTag = '#'.$t;
                    array_push($temp, $newTag);
                }
                $item->tags = implode(', ', $temp);
                // dd($item->tags);
            }
        }

        return view('pages.find', compact('new'));
    }

    public function about() {
        return view('pages.maintenance');
    }

    public function policy() {
        return view('pages.maintenance');
    }
}
