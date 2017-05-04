<?php

namespace Corp\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        // @set($i,10) я обошелся без этого, но буду иметь ввиду:) (а в уроках 18,19 уже не обошелся:(
        Blade::directive('set', function ($exp) {
            list($name, $val) = explode(',',$exp);
            return "<?php $name = $val ?>";
        });

        DB::listen(function ($query) {
            //echo '<h2>'.$query->sql.'</h2>';
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
