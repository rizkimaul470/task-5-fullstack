<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Articles;
use App\Models\Categories;

class MainPageController extends Controller
{
    public function articles(){
        $data = Articles::join('categories', 'articles.category_id', '=', 'categories.id')
        ->select('articles.*', 'categories.name as categoryname')
        ->orderBy('articles.created_at', 'DESC')
        ->cursorPaginate(6);
        $categories = Categories::all()->take(10);

        if($data->isEmpty()){
            return view('main.main', [
                'articles' => 'not found',
                'categories' => $categories
            ]);
        } else {
            return view('main.main', [
                'articles' => $data,
                'categories' => $categories
            ]);
        }
    }

    public function articlesById($id){
        $data = Articles::where('articles.id', $id)
        ->join('categories', 'articles.category_id', '=', 'categories.id')
        ->select('articles.*', 'categories.name as categoryname')
        ->first();
        $categories = Categories::all()->take(10);

        if($data){
            return view('main.mainById', [
                'article' => $data,
                'categories' => $categories
            ]);
        } else {
            return view('main.mainById', [
                'article' => 'not found',
                'categories' => $categories
            ]);
        }
    }

    public function categoryById($id){
        $data = Articles::where('category_id', $id)
        ->join('categories', 'articles.category_id', '=', 'categories.id')
        ->select('articles.*', 'categories.name as categoryname')
        ->orderBy('articles.created_at', 'DESC')
        ->cursorPaginate(6);
        $categories = Categories::all()->take(8);

        if($data){
            return view('main.main', [
                'articles' => $data,
                'categories' => $categories
            ]);
        } else {
            return view('main.main', [
                'articles' => 'not found',
                'categories' => $categories
            ]);
        }
    }
}
