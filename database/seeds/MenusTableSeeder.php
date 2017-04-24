<?php

use Illuminate\Database\Seeder;

class MenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menus')->insert([
                'title' => 'Главная',
                'path' => 'http://corp54.loc/',
                'parent' => 0,
            ]);
        DB::table('menus')->insert([
            'title' => 'Блог',
            'path' => 'http://corp54.loc/articles',
            'parent' => 0,
            ]);
        DB::table('menus')->insert([
            'title' => 'Компьютеры',
            'path' => 'http://corp54.loc/articles/cat/computers',
            'parent' => 2,
            ]);
        DB::table('menus')->insert([
            'title' => 'Интересное',
            'path' => 'http://corp54.loc/articles/cat/iteresting',
            'parent' => 2,
            ]);
        DB::table('menus')->insert([
            'title' => 'Советы',
            'path' => 'http://corp54.loc/articles/cat/soveti',
            'parent' => 2,
        ]);
        DB::table('menus')->insert([
            'title' => 'Портфолио',
            'path' => 'http://corp54.loc/portfolios',
            'parent' => 0,
        ]);
        DB::table('menus')->insert([
            'title' => 'Контакты',
            'path' => 'http://corp54.loc/contacts',
            'parent' => 0,
        ]);

    }
}
