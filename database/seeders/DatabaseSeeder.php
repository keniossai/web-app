<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(ActionSeeder::class);
        $this->call(MenuItemSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(CatalogSeeder::class);
        $this->call(StatusSeeder::class);
        // $this->call(CallFactoriesSeeder::class);
        // $this->call(DummySeeder::class);
    }
}
