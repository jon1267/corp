<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        /*$this->call(CategoriesTableSeeder::class);
        $this->call(ArticlesTableSeeder::class);
        $this->call(FiltersTableSeeder::class);
        $this->call(MenusTableSeeder::class);
        $this->call(SlidersTableSeeder::class);
        $this->call(PortfoliosTableSeeder::class);*/

        $this->call(RolesTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);

        $this->call(RoleUserTableSeeder::class);
        $this->call(PermRoleTableSeeder::class);

    }
}
