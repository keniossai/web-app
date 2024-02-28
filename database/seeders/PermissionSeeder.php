<?php

namespace Database\Seeders;

use App\Models\Action;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->adminPermissions();
        $this->clientPermissions();
        $this->scPermissions();
        $this->cPermissions();
        $this->ldsPermissions();
        $this->HeadCoordinationPermissions();
        $this->coordPermissions();
        $this->directoryAdminPermissions();
        $this->generalDirectorPermissions();
        $this->headDocumentProcessingPermissions();
        $this->hrDirectorPermissions();
        $this->operationsDirectorPermissions();
        $this->seniorCoordinatorPermissions();
        $this->wlmPermissions();
    }

    private function adminPermissions()
    {
        foreach(Action::where('active', 1)->get() as $action){
            Permission::firstOrCreate([
                'id_action' => $action->id_action,
                'id_role' => Role::where(['code' => 'admin'])->first()->id_role,
            ]);
        }
    }

    private function clientPermissions()
    {
        $actions = Action::where('active', 1)
            ->where('module', 'projects')
            ->orwhere('module', 'clients')
            ->orwhere('module', 'allocation')
            ->orwhere('module', 'wlm')
            ->orwhere('module', 'profile')
            ->orwhere('name', 'view-client')
            ->orwhere('name', 'view-project')
            ->get();

        foreach($actions as $action){
            Permission::firstOrCreate([
                'id_action' => $action->id_action,
                'id_role' => Role::where(['code' => 'client_owner'])->first()->id_role,
            ]);
        }
    }

    private function scPermissions()
    {
        $actions = Action::where('active', 1)
            ->where('module', 'allocation')
            ->orwhere('module', 'wlm')
            ->orwhere('module', 'profile')
            ->orwhere('name', 'view-client')
            ->orwhere('name', 'view-project')
            ->get();

        foreach($actions as $action){
            Permission::firstOrCreate([
                'id_action' => $action->id_action,
                'id_role' => Role::where(['code' => 'senior_consultant'])->first()->id_role,
            ]);
        }
    }

    private function cPermissions()
    {
        $actions = Action::where('active', 1)
            ->where('module', 'wlm')
            ->orwhere('module', 'profile')
            ->orwhere('name', 'view-client')
            ->orwhere('name', 'view-project')
            ->get();

        foreach($actions as $action){
            Permission::firstOrCreate([
                'id_action' => $action->id_action,
                'id_role' => Role::where(['code' => 'consultant'])->first()->id_role,
            ]);
        }
    }

    private function ldsPermissions()
    {
        $actions = Action::where('active', 1)
            ->where('module', 'wlm')
            ->orwhere('module', 'profile')
            ->orwhere('name', 'view-client')
            ->orwhere('name', 'view-project')
            ->get();

        foreach($actions as $action){
            Permission::firstOrCreate([
                'id_action' => $action->id_action,
                'id_role' => Role::where(['code' => 'lds'])->first()->id_role,
            ]);
        }
    }

    private function HeadCoordinationPermissions()
    {
        $actions = Action::where('active', 1)
            ->where('module', 'allocation')
            ->orwhere('module', 'profile')
            ->orwhere('name', 'view-client')
            ->orwhere('name', 'view-project')
            ->get();

        foreach($actions as $action){
            Permission::firstOrCreate([
                'id_action' => $action->id_action,
                'id_role' => Role::where(['code' => 'head_of_coordination'])->first()->id_role,
            ]);
        }
    }

    private function coordPermissions()
    {
        $actions = Action::where('active', 1)
            ->where('module', 'profile')
            ->orwhere('name', 'view-client')
            ->orwhere('name', 'view-project')
            ->get();

        foreach($actions as $action){
            Permission::firstOrCreate([
                'id_action' => $action->id_action,
                'id_role' => Role::where(['code' => 'coordinator'])->first()->id_role,
            ]);
        }
    }

    private function directoryAdminPermissions()
    {
        $actions = Action::where('active', 1)
            ->where('module', 'profile')
            ->orwhere('name', 'view-client')
            ->orwhere('name', 'view-project')
            ->get();

        foreach($actions as $action){
            Permission::firstOrCreate([
                'id_action' => $action->id_action,
                'id_role' => Role::where(['code' => 'directory_administrator'])->first()->id_role,
            ]);
        }
    }

    private function generalDirectorPermissions()
    {
        $actions = Action::where('active', 1)
            ->where('module', 'profile')
            ->orwhere('name', 'view-client')
            ->orwhere('name', 'view-project')
            ->get();

        foreach($actions as $action){
            Permission::firstOrCreate([
                'id_action' => $action->id_action,
                'id_role' => Role::where(['code' => 'general_director'])->first()->id_role,
            ]);
        }
    }

    private function headDocumentProcessingPermissions()
    {
        $actions = Action::where('active', 1)
            ->where('module', 'profile')
            ->orwhere('name', 'view-client')
            ->orwhere('name', 'view-project')
            ->get();

        foreach($actions as $action){
            Permission::firstOrCreate([
                'id_action' => $action->id_action,
                'id_role' => Role::where(['code' => 'head_of_document_processing'])->first()->id_role,
            ]);
        }
    }

    private function hrDirectorPermissions()
    {
        $actions = Action::where('active', 1)
            ->where('module', 'profile')
            ->orwhere('name', 'view-client')
            ->orwhere('name', 'view-project')
            ->get();

        foreach($actions as $action){
            Permission::firstOrCreate([
                'id_action' => $action->id_action,
                'id_role' => Role::where(['code' => 'hr_director'])->first()->id_role,
            ]);
        }
    }

    private function operationsDirectorPermissions()
    {
        $actions = Action::where('active', 1)
            ->where('module', 'profile')
            ->orwhere('name', 'view-client')
            ->orwhere('name', 'view-project')
            ->get();

        foreach($actions as $action){
            Permission::firstOrCreate([
                'id_action' => $action->id_action,
                'id_role' => Role::where(['code' => 'operations_director'])->first()->id_role,
            ]);
        }
    }

    private function seniorCoordinatorPermissions()
    {
        $actions = Action::where('active', 1)
            ->where('module', 'profile')
            ->orwhere('name', 'view-client')
            ->orwhere('name', 'view-project')
            ->get();

        foreach($actions as $action){
            Permission::firstOrCreate([
                'id_action' => $action->id_action,
                'id_role' => Role::where(['code' => 'senior_coordinator'])->first()->id_role,
            ]);
        }
    }

    private function wlmPermissions()
    {
        $actions = Action::where('active', 1)
            ->where('module', 'profile')
            ->orwhere('module', 'wlm')
            ->orwhere('name', 'view-client')
            ->orwhere('name', 'view-project')
            ->get();

        foreach($actions as $action){
            Permission::firstOrCreate([
                'id_action' => $action->id_action,
                'id_role' => Role::where(['code' => 'wlm'])->first()->id_role,
            ]);
        }
    }
}
