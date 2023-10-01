<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Category;

class AuthorController extends Controller
{
    public function index() {
        $title = 'Dashboard';
        return view('pages.author.dashboard', compact('title'));
    }

    public function createContent() {
        $category = Category::all();
        $title = 'Create new content';
        return view('pages.author.create', compact('category', 'title'));
    }

    public function postContent(Request $req) {
        if ($req->hasFile('img_thumb')) {
            $file = $req->file('img_thumb');
            // Get the original file name
            $fileName = $file->getClientOriginalName();
            
            // Move the file to a public directory (e.g., storage/app/public)
            $file->storeAs('public/images/thumbnail', $fileName);
        }

        $data = News::create([
            'title' => $req->title,
            'img_thumb' => $fileName ? $fileName : '',
            'category_id' => $req->category_id,
            'paragraph' => $req->paragraph
        ]);
        if ($data) {
            return redirect('/')->with('success', 'Success create new content. lets check it out!');
        } else {
            return redirect('/author/create')->with('error', 'Cannot create or update content!');
        }
    }
}
