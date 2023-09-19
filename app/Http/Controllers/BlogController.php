<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\BlogComment;
use App\Models\News;
use App\Models\Comment;

class BlogController extends Controller
{
    public function index($id) {
        $news = News::find($id);
        $comment = Comment::where('new_id', $id)->orderBy('created_at', 'desc')->get();
        
        return view('pages.blog', compact('news', 'comment'));
    }

    public function sendComment(Request $req) {
        $input = Comment::create([
            'email' => $req->email,
            'message' => $req->message,
            'new_id' => (int) $req->id
        ]);
        $data = [ 
            'msg' => $req->message, 
            'email'=> $req->email 
        ];
        
        event(new BlogComment($data));
    }
}
