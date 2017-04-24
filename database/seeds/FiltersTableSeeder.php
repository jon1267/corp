<?php

use Illuminate\Database\Seeder;

class FiltersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('filters')->insert([
                'title' => 'Brand Identity',
                'alias' => 'brand-identity',
            ]);
        DB::table('filters')->insert([
                'title' => 'Brand Hidentity',
                'alias' => 'brand-hidentity',
            ]);
    }
}
