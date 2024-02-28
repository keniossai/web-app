<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Product;
use App\Models\Project;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Project::class;

    public function definition()
    {
        $client = Client::inRandomOrder()->first();
        $year = Carbon::now()->format('Y');
        $user = User::whereHas('userRole', function ($query){
            $query->where('id_role', Role::where('code', 'client_owner')->first()->id_role);
        })->inRandomOrder()->first();
        return [
            'id_client' => $client->id_client,
            'id_product' => Product::inRandomOrder()->first()->id_product,
            'name' =>  $client->name .' '.$year,
            'description' => $this->faker->text,
            'year' => $year,
            'owner' => $user->id_user
        ];
    }
}
