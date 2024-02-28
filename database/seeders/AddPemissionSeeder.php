<?php

namespace Database\Seeders;

use App\Models\Action;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class AddPemissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->addPersmisionViewSubmission();
    }

    private function addPersmisionViewSubmission()
    {
       $action = Action::firstOrCreate(['module' => 'wlm', 'name' => 'view-submission']);
       $roles = Role::whereIn('code', ['admin', 'client_owner', 'lds', 'consultant', 'senior_consultant'])->get();
        foreach ($roles as $role) {
            Permission::firstOrCreate([
                 'id_action' => $action->id_action,
                 'id_role' => $role->id_role,
             ]);
        }
    }
}
