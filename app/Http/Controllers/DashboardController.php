<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Validator;

use App\Models\Articles;
use App\Models\Categories;

class DashboardController extends Controller
{
    public function index(){
        return view('dashboard.index');
    }

    public function showArticle(){
        $data = Articles::join('categories', 'articles.category_id', '=', 'categories.id')
        ->join('users', 'articles.user_id', '=', 'users.id')
        ->select('articles.*', 'users.name as username', 'categories.name as categoryname')
        ->where('users.id', Auth::user()->id)
        ->orderBy('articles.created_at', 'DESC')
        ->paginate('5');

        if($data->isEmpty()){
            return view('dashboard.articles.showArticle', [
                'articles' => "not found",
            ]);
        } else {
            return view('dashboard.articles.showArticle', [
                'articles' => $data,
            ]);
        }
    }

    public function createArticle(Request $request){
        return view('dashboard.articles.createArticle');
    }

    public function createImage(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'integer|required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:4096',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors(),
            ], 422);
        }

        $data = $request->except(['id', '_token']);
        $data['user_id'] = Auth::user()->id;

        $file = $request->file('image');
        $filename = time().'.'.$request->image->extension();
        $file->move(public_path('public/images'), $filename);
        $data['image'] = $filename;

        $query = Articles::where('id', $request->id)->update($data);

        if($query){
            return response()->json([
                'message' => 'Update Image Success',
            ]);
        } else {
            return response()->json([
                'message' => 'Cant Update Image',
            ]);
        }
    }

    // Categories

    public function showCategory(){
        $data = Categories::join('users', 'categories.user_id', '=', 'users.id')
        ->select('categories.*', 'users.name as username')
        ->paginate('5');

        if($data->isEmpty()){
            return view('dashboard.categories.showCategories', [
                'categories' => "not found",
            ]);
        } else {
            return view('dashboard.categories.showCategories', [
                'categories' => $data,
            ]);
        }
    }

    public function createCategory(){
        return view('dashboard.categories.createCategories');
    }
}
