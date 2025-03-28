<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MovieController extends Controller
{
    private const MOVIE_TABLE_NAME = "movies";
    private const COLUMNS_TO_SHOW = "id,director_id,title,original_title,tagline,budget,revenue,release_date,vote_count,vote_average,popularity,overview";

    private function getColumnsToShow() : string{
        $columnArray = [];
        
        foreach(explode(',',MovieController::COLUMNS_TO_SHOW) as $column){
            $columnArray[] = MovieController::MOVIE_TABLE_NAME . "." . $column;
        }
        
        return implode(",",$columnArray);
    } 

    public function index(Request $request){

        $page = $request->input('page');

        return DB::table(MovieController::MOVIE_TABLE_NAME)
                    ->select("id","title","original_title","budget","revenue","release_date","tagline")
                    ->offset($page == 1 ? 0 : $page * 10)
                    ->limit(10)
                    ->get();
    }

    public function show(int $id){
        return DB::table(MovieController::MOVIE_TABLE_NAME)
                    ->join('directors','directors.id','=','movies.director_id')
                    ->selectRaw($this->getColumnsToShow() . ",name as director_name,gender,
                    department")
                    ->where('movies.id',$id)
                    ->first(); 
    }

    public function info(){

        $movieInfo = DB::table(MovieController::MOVIE_TABLE_NAME)
                        ->selectRaw("count(id) as total_movies")
                        ->first();

        $movieInfo->popular_movie_name = DB::table(MovieController::MOVIE_TABLE_NAME)->selectRaw('title,max(popularity)')->value('title');

        $movieInfo->average_movies_budget = DB::table(MovieController::MOVIE_TABLE_NAME)->avg('budget');
                    
        $movieInfo->popular = DB::table(MovieController::MOVIE_TABLE_NAME)
                    ->selectRaw(MovieController::COLUMNS_TO_SHOW . ', max(popularity) as popular')
                    ->first(); 

        $movieInfo->most_earned = DB::table(MovieController::MOVIE_TABLE_NAME)
                        ->selectRaw(MovieController::COLUMNS_TO_SHOW . ', max(revenue - budget) as total_earning')
                        ->first();
        
        $movieInfo->most_voted = DB::table(MovieController::MOVIE_TABLE_NAME)
                        ->selectRaw(MovieController::COLUMNS_TO_SHOW . ', max(vote_count) / count(id) as total_votes')
                        ->first();   
    
        return $movieInfo;
    }
}
