<?php

namespace Database\Seeders;

use App\Models\Action;
use Illuminate\Database\Seeder;

class ActionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Action::firstOrCreate(['module' => 'profile', 'name' => 'my-profile']);
        Action::firstOrCreate(['module' => 'profile', 'name' => 'update-profile']);
        Action::firstOrCreate(['module' => 'profile', 'name' => 'delete-user-picture']);
        Action::firstOrCreate(['module' => 'profile', 'name' => 'search']);
        Action::firstOrCreate(['module' => 'profile', 'name' => 'leave']);
        Action::firstOrCreate(['module' => 'profile', 'name' => 'impersonate-user']);
        Action::firstOrCreate(['module' => 'profile', 'name' => 'search-users']);

        Action::firstOrCreate(['module' => 'projects', 'name' => 'projects']);
        Action::firstOrCreate(['module' => 'projects', 'name' => 'create-project']);
        Action::firstOrCreate(['module' => 'projects', 'name' => 'save-project']);
        Action::firstOrCreate(['module' => 'projects', 'name' => 'read-project']);
        Action::firstOrCreate(['module' => 'projects', 'name' => 'edit-project']);
        Action::firstOrCreate(['module' => 'projects', 'name' => 'view-project']);
        Action::firstOrCreate(['module' => 'projects', 'name' => 'delete-project']);
        Action::firstOrCreate(['module' => 'projects', 'name' => 'save-update-submissions']);
        Action::firstOrCreate(['module' => 'projects', 'name' => 'get-submission']);
        Action::firstOrCreate(['module' => 'projects', 'name' => 'get-guides-from-taxonomy']);
        Action::firstOrCreate(['module' => 'projects', 'name' => 'get-locations-from-taxonomy']);
        Action::firstOrCreate(['module' => 'projects', 'name' => 'get-practices-from-taxonomy']);
        Action::firstOrCreate(['module' => 'projects', 'name' => 'get-directories-from-taxonomy']);
        Action::firstOrCreate(['module' => 'projects', 'name' => 'get-catalog-taxonomies']);
        Action::firstOrCreate(['module' => 'projects', 'name' => 'get-dealine-directory']);
        Action::firstOrCreate(['module' => 'projects', 'name' => 'save-contact']);
        Action::firstOrCreate(['module' => 'projects', 'name' => 'edit-contact']);
        Action::firstOrCreate(['module' => 'projects', 'name' => 'delete-contact']);
        Action::firstOrCreate(['module' => 'projects', 'name' => 'delete-contact-rel']);

        Action::firstOrCreate(['module' => 'clients', 'name' => 'clients']);
        Action::firstOrCreate(['module' => 'clients', 'name' => 'create-client']);
        Action::firstOrCreate(['module' => 'clients', 'name' => 'read-client']);
        Action::firstOrCreate(['module' => 'clients', 'name' => 'save-client']);
        Action::firstOrCreate(['module' => 'clients', 'name' => 'get-client']);
        Action::firstOrCreate(['module' => 'clients', 'name' => 'delete-client']);
        Action::firstOrCreate(['module' => 'clients', 'name' => 'edit-client']);
        Action::firstOrCreate(['module' => 'clients', 'name' => 'view-client']);
        Action::firstOrCreate(['module' => 'clients', 'name' => 'delete-client-picture']);

        Action::firstOrCreate(['module' => 'allocation', 'name' => 'allocation']);
        Action::firstOrCreate(['module' => 'allocation', 'name' => 'update-submissions']);
        Action::firstOrCreate(['module' => 'allocation', 'name' => 'get-tasks-from-allocation']);

        Action::firstOrCreate(['module' => 'deadlines', 'name' => 'deadlines']);
        Action::firstOrCreate(['module' => 'deadlines', 'name' => 'create-deadline']);
        Action::firstOrCreate(['module' => 'deadlines', 'name' => 'save-deadline']);
        Action::firstOrCreate(['module' => 'deadlines', 'name' => 'read-deadline']);
        Action::firstOrCreate(['module' => 'deadlines', 'name' => 'view-deadline']);
        Action::firstOrCreate(['module' => 'deadlines', 'name' => 'edit-deadline']);
        Action::firstOrCreate(['module' => 'deadlines', 'name' => 'delete-deadline']);
        Action::firstOrCreate(['module' => 'deadlines', 'name' => 'save-deadline-header']);
        Action::firstOrCreate(['module' => 'deadlines', 'name' => 'read-deadlineheader']);
        Action::firstOrCreate(['module' => 'deadlines', 'name' => 'import-file-deadline']);
        Action::firstOrCreate(['module' => 'deadlines', 'name' => 'get-deadlines-by-header']);
        Action::firstOrCreate(['module' => 'deadlines', 'name' => 'update-deadline-submission']);
        Action::firstOrCreate(['module' => 'deadlines', 'name' => 'update-deadline-submission-today']);

        Action::firstOrCreate(['module' => 'wlm', 'name' => 'wlm']);
        Action::firstOrCreate(['module' => 'wlm', 'name' => 'update-status-c']);
        Action::firstOrCreate(['module' => 'wlm', 'name' => 'filter-tasks']);
        Action::firstOrCreate(['module' => 'wlm', 'name' => 'search-tasks']);
        Action::firstOrCreate(['module' => 'wlm', 'name' => 'export-tasks-wlm']);

        Action::firstOrCreate(['module' => 'wlm', 'name' => 'wlm-kanban']);
        Action::firstOrCreate(['module' => 'wlm', 'name' => 'update-status-kanban']);
        Action::firstOrCreate(['module' => 'wlm', 'name' => 'search-kanban-tasks']);

        Action::firstOrCreate(['module' => 'wlm', 'name' => 'view-submission']);

        Action::firstOrCreate(['module' => 'catalogs', 'name' => 'directories']);
        Action::firstOrCreate(['module' => 'catalogs', 'name' => 'guides']);
        Action::firstOrCreate(['module' => 'catalogs', 'name' => 'locations']);

        Action::firstOrCreate(['module' => 'security', 'name' => 'users']);
        Action::firstOrCreate(['module' => 'security', 'name' => 'create-user']);
        Action::firstOrCreate(['module' => 'security', 'name' => 'save-user']);
        Action::firstOrCreate(['module' => 'security', 'name' => 'read-user']);
        Action::firstOrCreate(['module' => 'security', 'name' => 'edit-user']);
        Action::firstOrCreate(['module' => 'security', 'name' => 'deactivate-user']);

        Action::firstOrCreate(['module' => 'security', 'name' => 'roles']);
        Action::firstOrCreate(['module' => 'security', 'name' => 'save-role']);
        Action::firstOrCreate(['module' => 'security', 'name' => 'read-role']);
        Action::firstOrCreate(['module' => 'security', 'name' => 'edit-role']);
        Action::firstOrCreate(['module' => 'security', 'name' => 'deactivate-role']);
        Action::firstOrCreate(['module' => 'security', 'name' => 'delete-user-role']);
        Action::firstOrCreate(['module' => 'security', 'name' => 'save-user-role']);

        Action::firstOrCreate(['module' => 'security', 'name' => 'actions']);
        Action::firstOrCreate(['module' => 'security', 'name' => 'save-action']);
        Action::firstOrCreate(['module' => 'security', 'name' => 'read-action']);
        Action::firstOrCreate(['module' => 'security', 'name' => 'deactivate-action']);

        Action::firstOrCreate(['module' => 'security', 'name' => 'permissions']);
        Action::firstOrCreate(['module' => 'security', 'name' => 'save-permission']);
        Action::firstOrCreate(['module' => 'security', 'name' => 'read-permission']);
        Action::firstOrCreate(['module' => 'security', 'name' => 'delete-permission']);

        Action::firstOrCreate(['module' => 'security', 'name' => 'menuitems']);
        Action::firstOrCreate(['module' => 'security', 'name' => 'save-menuitem']);
        Action::firstOrCreate(['module' => 'security', 'name' => 'read-menuitem']);
        Action::firstOrCreate(['module' => 'security', 'name' => 'deactivate-menuitem']);

        Action::firstOrCreate(['module' => 'directory_taxonomy', 'name' => 'directory-taxonomy']);
        Action::firstOrCreate(['module' => 'directory_taxonomy', 'name' => 'create-directory']);
        Action::firstOrCreate(['module' => 'directory_taxonomy', 'name' => 'save-directory']);
        Action::firstOrCreate(['module' => 'directory_taxonomy', 'name' => 'get-directory']);
        Action::firstOrCreate(['module' => 'directory_taxonomy', 'name' => 'delete-directory']);
        Action::firstOrCreate(['module' => 'directory_taxonomy', 'name' => 'save-all-directory-taxonomy']);
        Action::firstOrCreate(['module' => 'directory_taxonomy', 'name' => 'get-central-practice']);

        Action::firstOrCreate(['module' => 'directory_taxonomy', 'name' => 'create-guide']);
        Action::firstOrCreate(['module' => 'directory_taxonomy', 'name' => 'save-guide']);
        Action::firstOrCreate(['module' => 'directory_taxonomy', 'name' => 'get-guide']);
        Action::firstOrCreate(['module' => 'directory_taxonomy', 'name' => 'get-guides-by-directory']);
        Action::firstOrCreate(['module' => 'directory_taxonomy', 'name' => 'get-practices-by-directory']);
        Action::firstOrCreate(['module' => 'directory_taxonomy', 'name' => 'delete-guide']);

        Action::firstOrCreate(['module' => 'directory_taxonomy', 'name' => 'create-location']);
        Action::firstOrCreate(['module' => 'directory_taxonomy', 'name' => 'save-location']);
        Action::firstOrCreate(['module' => 'directory_taxonomy', 'name' => 'get-location']);
        Action::firstOrCreate(['module' => 'directory_taxonomy', 'name' => 'delete-location']);

        Action::firstOrCreate(['module' => 'directory_taxonomy', 'name' => 'create-practice']);
        Action::firstOrCreate(['module' => 'directory_taxonomy', 'name' => 'save-practice']);
        Action::firstOrCreate(['module' => 'directory_taxonomy', 'name' => 'get-practice']);
        Action::firstOrCreate(['module' => 'directory_taxonomy', 'name' => 'delete-practice']);

        Action::firstOrCreate(['module' => 'security', 'name' => 'groups']);
        Action::firstOrCreate(['module' => 'security', 'name' => 'create-group']);
        Action::firstOrCreate(['module' => 'security', 'name' => 'read-group']);
        Action::firstOrCreate(['module' => 'security', 'name' => 'save-group']);
        Action::firstOrCreate(['module' => 'security', 'name' => 'save-user-group']);
        Action::firstOrCreate(['module' => 'security', 'name' => 'get-group-detail']);
        Action::firstOrCreate(['module' => 'security', 'name' => 'edit-group']);
        Action::firstOrCreate(['module' => 'security', 'name' => 'deactivate-group']);
        Action::firstOrCreate(['module' => 'security', 'name' => 'deactivate-groupdetail']);
    }
}
