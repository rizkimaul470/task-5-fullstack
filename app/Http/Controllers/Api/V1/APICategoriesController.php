<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Categories;

class APICategoriesController extends Controller
{
    public function show(){
        return response()->json([
            "message" => "Request Success",
            "data" => Categories::all(),
        ], 200);
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'string|required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors(),
            ], 422);
        }

        $data = [
            'name' => $request->name,
            'user_id' => Auth::user()->id,
        ];

        $query = Categories::create($data);

        if($query){
            return response()->json([
                'message' => 'Input Categories Success',
            ]);
        } else {
            return response()->json([
                'message' => 'Cant Input Categories',
            ]);
        }
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'old_name' => 'string|required',
            'name' => 'string|required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors(),
            ], 422);
        }

        $data = [
            'name' => $request->name,
            'user_id' => Auth::user()->id,
        ];

        $query = Categories::where('name', $request->old_name)->update($data);

        if($query){
            return response()->json([
                'message' => 'Update Categories Success',
            ]);
        } else {
            return response()->json([
                'message' => 'Cant Update Categories',
            ]);
        }
    }

    public function delete(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'string|required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors(),
            ], 422);
        }

        $query = Categories::where('name', $request->name)->delete();

        if($query){
            return response()->json([
                'message' => 'Delete Categories Success',
            ]);
        } else {
            return response()->json([
                'message' => 'Cant Delete Categories',
            ]);
        }
    }
}
