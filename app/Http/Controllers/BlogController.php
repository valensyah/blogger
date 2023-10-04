<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\BlogComment;
use App\Models\News;
use App\Models\Comment;
use App\Models\user;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    public function index($id) {
        $news = News::find($id);
        $temp = [];
        if ($news->tags) {
            $tag = explode(",", $news->tags);
            foreach ($tag as $t) {
                $newTag = '#'.$t;
                array_push($temp, $newTag);
            }
            $news->tags = implode(', ', $temp);
            // dd($item->tags);
        }
        $comment = Comment::where('new_id', $id)->orderBy('created_at', 'desc')->get();
        foreach($comment as $item) {
            $msgSent = Carbon::parse($item->created_at);
            $now = Carbon::now();
            $timeDiffInSec = $now->diffInSeconds($msgSent);
            $timeDiff = $now->diffForHumans($msgSent);
            $item->time = $timeDiff;
        }
        
        return view('pages.blog', compact('news', 'comment'));
    }

    public function sendComment(Request $req) {
        // $rules = [
        //     'email' => 'required|unique:comments',
        //     'message' => 'required'
        // ];

        // $errMsg = [
        //     'email.required' => 'email field is required.',
        //     'email.unique' => 'email already in use.',
        //     'message.required' => 'message field is required.'
        // ];

        // // Perform validation
        // $validator = Validator::make($req->all(), $rules, $errMsg);

        // Check if validation fails
        // if ($validator->fails()) {
        //     return redirect()->back()->withErrors($validator)->withInput();
        // }

        $input = Comment::create([
            'email' => Auth::check() ? Auth::user()->name : $req->email,
            'message' => $req->message,
            'new_id' => (int) $req->id
        ]);
        $data = [ 
            'msg' => $req->message, 
            'email'=> Auth::check() ? Auth::user()->name : $req->email,
            'time' =>  'now'
        ];
        
        event(new BlogComment($data));
    }
}
