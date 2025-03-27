<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Director;
use App\Models\Movie;
use Illuminate\Database\RecordNotFoundException;

class DirectorController extends Controller
{
    public function index(){

        return DB::table('directors')
                    ->select('id','name','gender') 
                    ->orderBy('id')
                    ->limit(20)
                    ->get();
    }

    public function show(int $id){

        return DB::table('directors')
                    ->select('id','name','gender','department')
                    ->find($id);
    }

    public function withMovies(){

        $directors =  DB::table('directors')
                    ->select('id','name','gender') 
                    ->orderBy('id')
                    ->limit(20)
                    ->get();

        $directors->map(function($director){
            $data = DB::table('movies')
                        ->select('id','title')
                        ->where('director_id',$director->id)
                        ->get();

            $director->movies = $data;
        });

        return $directors;
    }

    public function WithAllMoviesInfo(int $id){
        // $director = Director::findOrFail($id);
        $director = DB::table('directors')
                        ->select('id','name','gender','department')
                        ->find($id);

        if(!$director)
            abort(404);

        $movies = DB::table('movies')
                    ->select('id','title','original_title','tagline','budget','revenue','release_date','vote_count','vote_average','popularity','overview','director_id')
                    ->where('director_id',$director->id)
                    ->get();

        $director->movies = $movies;

        return $director;
    }
}
