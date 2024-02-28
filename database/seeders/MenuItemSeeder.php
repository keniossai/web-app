<?php

namespace Database\Seeders;

use App\Models\Action;
use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createMenuItems();
    }

    private function createMenuItems()
    {
        MenuItem::firstOrCreate([
            'name' => 'Projects',
            'icon' => 'la la-stamp',
            'id_action' => Action::where(['name' => 'projects'])->first()->id_action,
            'order' => 1,
        ]);

        MenuItem::firstOrCreate([
            'name' => 'Clients',
            'icon' => 'la la-stamp',
            'id_action' => Action::where(['name' => 'clients'])->first()->id_action,
            'order' => 5,
        ]);

        MenuItem::firstOrCreate([
            'name' => 'Allocation',
            'icon' => 'la la-stamp',
            'id_action' => Action::where(['name' => 'allocation'])->first()->id_action,
            'order' => 10,
        ]);

        MenuItem::firstOrCreate([
            'name' => 'Deadlines',
            'icon' => 'la la-stamp',
            'id_action' => Action::where(['name' => 'deadlines'])->first()->id_action,
            'order' => 15,
        ]);

        $menuWlm = MenuItem::firstOrCreate([
            'name' => 'WLM',
            'icon' => 'la la-stamp',
            'order' => 20,
        ]);

        MenuItem::firstOrCreate([
            'father_id_menuitem' => $menuWlm->id_menuitem,
            'name' => 'List',
            'icon' => 'la la-stamp',
            'id_action' => Action::where(['name' => 'wlm'])->first()->id_action,
            'order' => 2,
        ]);

        MenuItem::firstOrCreate([
            'father_id_menuitem' => $menuWlm->id_menuitem,
            'name' => 'Kanban',
            'icon' => 'la la-stamp',
            'id_action' => Action::where(['name' => 'wlm-kanban'])->first()->id_action,
            'order' => 5,
        ]);

        $menuCatalog = MenuItem::firstOrCreate([
            'name' => 'Catalogs',
            'icon' => 'la la-stamp',
            'order' => 25,
        ]);

        MenuItem::firstOrCreate([
            'father_id_menuitem' => $menuCatalog->id_menuitem,
            'name' => 'Directory Taxonomy',
            'icon' => 'las la-mitten',
            'id_action' => Action::where(['name' => 'directory-taxonomy'])->first()->id_action,
            'order' => 1,
        ]);


        $menuSystemcatalog = MenuItem::firstOrCreate([
            'name' => 'Security',
            'icon' => 'la la-stamp',
            'order' => 30,
        ]);

        MenuItem::firstOrCreate([
            'father_id_menuitem' => $menuSystemcatalog->id_menuitem,
            'name' => 'Users',
            'icon' => 'las la-mitten',
            'id_action' => Action::where(['name' => 'users'])->first()->id_action,
            'order' => 1,
        ]);

        MenuItem::firstOrCreate([
            'father_id_menuitem' => $menuSystemcatalog->id_menuitem,
            'name' => 'Roles',
            'icon' => 'las la-mitten',
            'id_action' => Action::where(['name' => 'roles'])->first()->id_action,
            'order' => 5,
        ]);

        MenuItem::firstOrCreate([
            'father_id_menuitem' => $menuSystemcatalog->id_menuitem,
            'name' => 'Groups',
            'icon' => 'las la-mitten',
            'id_action' => Action::where(['name' => 'groups'])->first()->id_action,
            'order' => 8,
        ]);

        MenuItem::firstOrCreate([
            'father_id_menuitem' => $menuSystemcatalog->id_menuitem,
            'name' => 'Permissions',
            'icon' => 'las la-mitten',
            'id_action' => Action::where(['name' => 'permissions'])->first()->id_action,
            'order' => 10,
        ]);

        MenuItem::firstOrCreate([
            'father_id_menuitem' => $menuSystemcatalog->id_menuitem,
            'name' => 'Actions',
            'icon' => 'las la-mitten',
            'id_action' => Action::where(['name' => 'actions'])->first()->id_action,
            'order' => 15,
        ]);

        MenuItem::firstOrCreate([
            'father_id_menuitem' => $menuSystemcatalog->id_menuitem,
            'name' => 'Menus',
            'icon' => 'las la-mitten',
            'id_action' => Action::where(['name' => 'menuitems'])->first()->id_action,
            'order' => 20,
        ]);
    }
}
