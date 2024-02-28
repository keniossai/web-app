<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\Taxonomy;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Task::class;

    public function definition()
    {
        $taxonomy = Taxonomy::inRandomOrder()->first();
        return [
            'id_directory' => $taxonomy->id_directory,
            'id_guide' => $taxonomy->id_guide,
            'id_location' =>  $taxonomy->id_location,
            'id_practice' => $taxonomy->id_practice,
        ];
    }
}
