<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Movie;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movie>
 */
class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "original_title" => fake()->realText(20),
            "budget" => fake()->numberBetween(500000,100000000),
            "popularity" => fake()->numberBetween(0,150),
            "release_date" => fake()->date(),
            "revenue" => fake()->numberBetween(500000,100000000),
            "title" => fake()->realText(50),
            "vote_average" => fake()->randomFloat(1,1,10),
            "vote_count" => fake()->numberBetween(500,5000),
            "overview" => fake()->text(),
            "tagline" => fake()->realText(),
            "uid" => fake()->numberBetween(0,700),
            "director_id" => \App\Models\Director::factory()->create(),
        ];
    }

    public function load() : void
    {
        $str_movies =  \Illuminate\Support\Facades\File::get(base_path("database\json data\movies.json"));
        $movies = json_decode($str_movies,true);

        foreach($movies as $movie){
            Movie::create([
                "id" => $movie["id"],
                "original_title" => $movie["original_title"],
                "budget" => $movie["budget"],
                "popularity" => $movie["popularity"],
                "release_date" => $movie["release_date"],
                "revenue" => $movie["revenue"],
                "title" => $movie["title"],
                "vote_average" => $movie["vote_average"],
                "vote_count" => $movie["vote_count"],
                "overview" => $movie["overview"],
                "tagline" => $movie["tagline"],
                "uid" => $movie["uid"],
                "director_id" => $movie["director_id"],
            ]);
        }
    }
}
