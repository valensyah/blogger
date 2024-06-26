<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Category;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Pusher\Pusher;
use DB;

class AuthorController extends Controller
{
    public function index() {
        $title = 'Dashboard';
        $data = News::where('user_id', Auth::user()->id)->with('category')->paginate(5);
        $comments = Comment::where(function ($query) use ($data) {
            $query->whereIn('new_id', $data->pluck('id'));
        })->count();
        foreach ($data as $item) {
            $tags = explode(",", $item->tags);
            $newTag = [];
            foreach ($tags as $tag) {
                $tag = '#'.$tag;
                array_push($newTag, $tag);
            }
            $item->tags = implode(", ", $newTag);
        }
        return view('pages.author.dashboard', compact('title', 'data', 'comments'));
    }

    public function createContent() {
        $category = Category::all();
        $title = 'Create new content';
        return view('pages.author.create', compact('category', 'title'));
    }

    public function updateContent($id) {
        $title = 'Update content';
        $category = Category::all();
        $data = News::find($id);
        return view('pages.author.update', compact('category', 'title', 'data'));
    }

    public function postContent(Request $req) {
        $fileName = '';
        if ($req->hasFile('img_thumb')) {
            $file = $req->file('img_thumb');
            // Get the original file name
            $fileName = $file->getClientOriginalName();
            
            // Move the file to a public directory (e.g., storage/app/public)
            $file->storeAs('public/images/thumbnail', $fileName);
        }
        // dd(Auth::user()->id);
        $data = News::create([
            'user_id' => Auth::user()->id,
            'title' => $req->title,
            'img_thumb' => $fileName ? $fileName : '',
            'category_id' => $req->category_id,
            'paragraph' => $req->paragraph,
            'tags' => $req->tags
        ]);
        if ($data) {
            return redirect('/author')->with('success', 'Success create new content. lets check it out!');
        } else {
            return redirect('/author/create')->with('error', 'Cannot create or update content!');
        }
    }

    public function editContent(Request $req, $id) {
        $fileName = '';
        if ($req->hasFile('img_thumb')) {
            $file = $req->file('img_thumb');
            // Get the original file name
            $fileName = $file->getClientOriginalName();
            
            // Move the file to a public directory (e.g., storage/app/public)
            $file->storeAs('public/images/thumbnail', $fileName);
            $updateImg = News::where('id', $id)
            ->update([
                'img_thumb' => $fileName
            ]);
        }

        $data = News::where('id', $id)
        ->update([
            'title' => $req->title,
            'category_id' => $req->category_id,
            'paragraph' => $req->paragraph,
            'tags' => $req->tags
        ]);
        // dd($data);
        return redirect('/author')->with('success', 'Success update new content. lets check it out!');
        // if ($data) {
        // } else {
        //     return redirect('/author/create')->with('error', 'Cannot create or update content!');
        // }
    }

    public function deleteContent($id) {
        $remove = News::find($id);
        $delete = $remove->delete();
        if ($delete) {
            return response()->json([
                'status' => 200,
                'message' => 'Data berhasil dihapus.'
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'Terjadi kesalahan saat menghapus data.'
            ]);
        }
    }

    public function notification($email) {
        $message = DB::table('comments')
                    ->select('comments.*')
                    ->join('news', 'news.id', '=', 'comments.new_id')
                    ->join('users', 'users.id', '=', 'news.user_id')
                    ->where('users.email', $email)
                    ->get();
        return response()->json($message);
    }
}
