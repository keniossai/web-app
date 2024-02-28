<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        Role::firstOrCreate([
            'name' => 'Admin',
            'code' => 'admin'
        ]);

        Role::firstOrCreate([
            'name' => 'General Director',
            'code' => 'general_director'
        ]);

        Role::firstOrCreate([
            'name' => 'HR Director',
            'code' => 'hr_director'
        ]);

        Role::firstOrCreate([
            'name' => 'Operations Director',
            'code' => 'operations_director'
        ]);

        Role::firstOrCreate([
            'name' => 'Client Owner',
            'code' => 'client_owner'
        ]);

        // Role::firstOrCreate([
        //     'name' => 'Managing Consultant',
        // ]);

        Role::firstOrCreate([
            'name' => 'Senior Consultant',
            'code' => 'senior_consultant'
        ]);

        Role::firstOrCreate([
            'name' => 'Consultant',
            'code' => 'consultant'
        ]);

        Role::firstOrCreate([
            'name' => 'LDS',
            'code' => 'lds'
        ]);

        Role::firstOrCreate([
            'name' => 'Head of Coordination',
            'code' => 'head_of_coordination'
        ]);

        Role::firstOrCreate([
            'name' => 'Senior Coordinator',
            'code' => 'senior_coordinator'
        ]);

        Role::firstOrCreate([
            'name' => 'Coordinator',
            'code' => 'coordinator'
        ]);

        Role::firstOrCreate([
            'name' => 'Head of Document Processing',
            'code' => 'head_of_document_processing'
        ]);

        Role::firstOrCreate([
            'name' => 'Directory Administrator',
            'code' => 'directory_administrator'
        ]);

        Role::firstOrCreate([
            'name' => 'Guest',
            'code' => 'guest'
        ]);

        Role::firstOrCreate([
            'name' => 'WLM',
            'code' => 'wlm'
        ]);
    }
}
