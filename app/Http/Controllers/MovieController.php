<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MovieController extends Controller
{
    public function index(){
        return DB::table('movies')
                    ->select("id","title","original_title","budget","revenue","release_date","tagline")
                    ->limit(20)
                    ->get();
    }

    public function show(int $id){
        return DB::table('movies')
                    ->join('directors','directors.id','=','movies.director_id')
                    ->selectRaw("movies.*,name as director_name,gender,
                    department")
                    ->where('movies.id',$id)
                    ->first(); 
    }
}
