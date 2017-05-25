<?php

namespace Corp\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Corp\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class IndexController extends AdminController
{
    public function __construct()
    {
        parent::__construct();

        // не работает (бл!!!) код из лары 5.2 в ларе 5.4 и весь
        // огород с Gate::denies() $user->canDo('VIEW_ADMIN') не робыть.


        if(!Gate::denies('VIEW_ADMIN')) {
            abort(403);
        }

        $this->template = env('THEME').'.admin.index';
    }

    public function index() {

        //$this->user = Auth::user(); //тут работает

        //$this->template = env('THEME').'.admin.index';

        $this->title = 'Панель администратора  ';
        return $this->renderOutput();
    }

}
