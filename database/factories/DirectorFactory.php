<?php

namespace Database\Factories;

use App\Models\Director;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Director>
 */
class DirectorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $genders = ["male","female","other"];

        return [
            "name" => fake()->name(),
            "gender" => $genders[rand(0,2)],
            "uid" => fake()->numberBetween(0,50000),
            "department" => "Directing"
        ];
    }

    public function load(): void
    {        
        $str_directors =  \Illuminate\Support\Facades\File::get(base_path("database\json data\directors.json"));
        $directors = json_decode($str_directors,true);

        foreach($directors as $director){
            $gender = "male";
            if($director["gender"] == 0)
                $gender = "other";
            else if($director["gender"] == 1)
                $gender = "female";
            
            Director::create([
                "id" => $director["id"],
                "name" => $director["name"],
                "gender" => $gender,
                "uid" => $director["uid"],
                "department" => $director["department"]
            ]);
        }
    }
}
