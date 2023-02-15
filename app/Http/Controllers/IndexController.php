<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class IndexController extends Controller
{
    public function view(){
        return view("index");
    }
    public function add(Request $req){
        $req->validate(
            [
'car_name' => 'required',
'car_price' => 'required',
'car_model' => 'required'
            ]
            );
        $result = DB::table("cars")->insert([
            "car_name" => $req->car_name,
            "car_price" => $req->car_price,
            "car_model" => $req->car_model
        ]);
    }
    public function show(){
        $cars = DB::table("cars")->get();
        return response()->json(['cars' => $cars],200);
    }

    public function update(Request $req){
        $result = DB::table("cars")->where("id" , $req->id)->update([
            "car_name" => $req->car_name_u,
            "car_price" => $req->car_price_u,
            "car_model" => $req->car_model_u
        ]);
            return response()->json(['result'=>$result]);
    }
    public function delete($id){
        $result = DB::table("cars")->where("id",$id)->delete();
        return response()->json(['result' => $result]);
    }
}
