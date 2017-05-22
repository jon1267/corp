<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            'name' => 'VIEW_ADMIN'
        ]);
        DB::table('permissions')->insert([
            'name' => 'ADD_ARTICLES'
        ]);
        DB::table('permissions')->insert([
            'name' => 'UPDATE_ARTICLES'
        ]);
        DB::table('permissions')->insert([
            'name' => 'DELETE_ARTICLES'
        ]);
        DB::table('permissions')->insert([
            'name' => 'ADMIN_USERS'
        ]);
        DB::table('permissions')->insert([
            'name' => 'VIEW_ADMIN_ARTICLES'
        ]);
        DB::table('permissions')->insert([
            'name' => 'EDIT_USERS'
        ]);
    }
}
