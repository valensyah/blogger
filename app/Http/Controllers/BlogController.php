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
use Pusher\Pusher;

class BlogController extends Controller
{
    public function index($id) {
        $news = News::with('user')->find($id);
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
        $news->formated_date = Carbon::parse($news->created_at)->format('d F Y');
        // dd($news->created_at);
        $comment = Comment::where('new_id', $id)->orderBy('created_at', 'desc')->get();
        foreach($comment as $item) {
            $msgSent = Carbon::parse($item->created_at);
            $now = Carbon::now();
            $timeDiffInSec = $now->diffInSeconds($msgSent);
            $timeDiff = $now->diffForHumans($msgSent);
            $item->time = $timeDiff;
        }
        // return response()->json($news);
        return view('pages.blog', compact('news', 'comment'));
    }

    public function getContentById($id) {
        $news = News::with('user')->find($id);
        $temp = [];
        if ($news->tags) {
            $tag = explode(",", $news->tags);
            foreach ($tag as $t) {
                $newTag = '#'.$t;
                array_push($temp, $newTag);
            }
            $news->tags = implode(', ', $temp);
        }
        $comment = Comment::where('new_id', $id)->orderBy('created_at', 'desc')->get();
        foreach($comment as $item) {
            $msgSent = Carbon::parse($item->created_at);
            $now = Carbon::now();
            $timeDiffInSec = $now->diffInSeconds($msgSent);
            $timeDiff = $now->diffForHumans($msgSent);
            $item->time = $timeDiff;
        }
        
        return response()->json([
            'status' => 200,
            'message' => 'Data berhasil didapatkan',
            'data' => [
                'content' => $news,
                'comment' => $comment
            ]
            ]);
    }

    public function sendComment(Request $req) {
        $pusher = new Pusher(env('PUSHER_APP_KEY'), env('PUSHER_APP_SECRET'), env('PUSHER_APP_ID'), [
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'useTLS' => true
        ]);

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
        
        //event(new BlogComment($data));
        $pusher->trigger('comment', 'sendComment', $data);
        return response()->json($data);
    }
}
