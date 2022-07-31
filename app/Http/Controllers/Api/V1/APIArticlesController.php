<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Articles;
use Illuminate\Support\Facades\File;

class APIArticlesController extends Controller
{
    public function show(){
        return response()->json([
            "message" => "Request Success",
            "data" => Articles::all(),
        ], 200);
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'string|required',
            'content' => 'string|required',
            'image' => 'image|required|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'category_id' => 'integer|required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors(),
            ], 422);
        }

        // Image Request
        $file = $request->file('image');
        $filename = time().'.'.$request->image->extension();
        $file->move(public_path('public/images'), $filename);

        $data = [
            'title' => $request->title,
            'content' => $request->content,
            'image' => $filename,
            'user_id' => Auth::user()->id,
            'category_id' => $request->category_id,
        ];

        $query = Articles::create($data);

        if($query){
            return response()->json([
                'message' => 'Input Article Success',
            ]);
        } else {
            return response()->json([
                'message' => 'Cant Input Article',
            ]);
        }
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'integer|required',
            'title' => 'string',
            'content' => 'string',
            'category_id' => 'integer',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors(),
            ], 422);
        }

        $data = $request;
        $data['user_id'] = Auth::user()->id;

        $query = Articles::where('id', $request->id)->update($data->except(['id']));

        if($query){
            return response()->json([
                'message' => 'Update Article Success',
            ]);
        } else {
            return response()->json([
                'message' => 'Cant Update Article',
            ]);
        }
    }

    public function delete(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'integer|required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors(),
            ], 422);
        }

        $query = Articles::where('id', $request->id)->first();
        File::delete('public/images/'.$query->image);
        $query->delete();

        if($query){
            return response()->json([
                'message' => 'Delete Article Success',
            ]);
        } else {
            return response()->json([
                'message' => 'Cant Delete Article',
            ]);
        }
    }
}
