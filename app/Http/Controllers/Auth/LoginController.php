<?php

namespace Corp\Http\Controllers\Auth;

use Corp\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    // 2 строки ниже добавил я...
    ////protected $loginView;
    ////protected $username = 'login';

    //protected $redirectTo = '/home';
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);

        // строку ниже тоже добавил я...
        ////$this->loginView = config('settings.theme').'.login';
    }

/*    public function showLoginForm() {

        $view = property_exists($this,'loginView') ? $this->loginView : '';

        if (view()->exists($view)) {
            return view($view)->with('title', 'Вход на сайт');
        }
        abort(404);
        //return view(config('settings.theme').'.login');
    }*/
}
