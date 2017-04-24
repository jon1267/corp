<?php

use Illuminate\Database\Seeder;

class SlidersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sliders')->insert([
            'title' => '<h2 style="color:#fff">CORPORATE, MULTIPURPOSE.. <br /><span>PINK RIO</span></h2>',
            'desc' => 'Nam id quam a odio euismod pellentesque. Etiam congue rutrum risus non vestibulum. Quisque a diam at ligula blandit consequat. Mauris ac mi velit, a tempor neque',
            'img' => 'xx.jpg',
            ]);
        DB::table('sliders')->insert([
            'title' => '<h2 style="color:#fff">PINKRIO. <span>STRONG AND POWERFUL.</span></h2>',
            'desc' => 'Nam id quam a odio euismod pellentesque. Etiam congue rutrum risus non vestibulum. Quisque a diam at ligula blandit consequat. Mauris ac mi velit, a tempor neque',
            'img' => '00314.jpg',
            ]);
        DB::table('sliders')->insert([
            'title' => '<h2 style="color:#fff">ENJOY THE VIDEO SUPPORT  <span>STRONG AND POWERFUL.</span></h2>',
            'desc' => 'Nam id quam a odio euismod pellentesque. Etiam congue rutrum risus non vestibulum. Quisque a diam at ligula blandit consequat. Mauris ac mi velit, a tempor neque',
            'img' => 'dd.jpg',
            ]);

    }
}
