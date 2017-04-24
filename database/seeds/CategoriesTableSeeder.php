<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
                'title' => 'Блог',
                'parent_id' => 0,
                'alias' => 'blog',
            ]);
        DB::table('categories')->insert([
                'title' => 'Компьютеры',
                'parent_id' => 1,
                'alias' => 'computers',
            ]);
        DB::table('categories')->insert([
                'title' => 'Интересное',
                'parent_id' => 1,
                'alias' => 'interesting',
            ]);
        DB::table('categories')->insert([
                'title' => 'Советы',
                'parent_id' => 1,
                'alias' => 'soveti',
            ]);
    }
}
