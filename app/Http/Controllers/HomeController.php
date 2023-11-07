<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\BlogComment;
use App\Models\News;
use App\Models\Category;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index() {
        $news = News::with('category', 'user')->orderBy('updated_at', 'DESC')->paginate(15);
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
        return view('pages.home', compact('news'));
    }

    public function getAllContent() {
        try {
            $news = News::with('category', 'user')->orderBy('updated_at', 'DESC')->get();
            if (count($news) > 0 || $news) {
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
    
                return response()->json([
                    'status' => 200,
                    'message' => 'Berhasil mendapatkan data',
                    'data' => $news
                ]);
            } else {
                return response()->json([
                    'status' => 200,
                    'message' => 'Data belum tersedia',
                    'data' => null
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'message' => 'Terjadi Kesalahan Pada Sistem',
                'data' => null
            ]);
        }
    }
    
    public function searchContent(Request $req) {
        if (!$req->keyword) {
            return redirect('/');
        }
        $category = Category::where('title', 'like', '%'.$req->keyword.'%')->get();
        $new = News::where('title', 'like', '%'.$req->keyword.'%')
        ->orWhere('tags', 'like', '%'.$req->keyword.'%')
        ->orWhere(function ($query) use ($category) {
            $query->whereIn('category_id', $category->pluck('id'));
        })
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
