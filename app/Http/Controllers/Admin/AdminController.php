<?php

namespace Corp\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Corp\Http\Controllers\Controller;
use Auth;
use Menu;

//class AdminController extends Controller
class AdminController extends \Corp\Http\Controllers\Controller
{
    //хранят объекты: портфолио, articles, user, шаблон,
    // и содержимое (html) страниц админки.
    protected $p_rep;
    protected $a_rep;
    protected $user;
    protected $template;
    protected $content = false;
    protected $title;
    protected $vars; // массив перем., передаваем.в шаблон

    public function __construct()
    {
        //$this->user = Auth::user();//Auth::user() вернет объект аут.польз.
        //dd($this->user);

        /*if (!$this->user) {
            abort(403);
        }*/

        //$this->template = config('settings.theme').'.layouts.admin';
    }

    public function renderOutput() {

        $this->vars = array_add($this->vars, 'title', $this->title);

        $menu = $this->getMenu();

        $navigation = view(config('settings.theme').'.admin.navigation')->with('menu', $menu)->render();
        $this->vars = array_add($this->vars, 'navigation', $navigation);

        if($this->content) {
            $this->vars = array_add($this->vars, 'content', $this->content);
        }

        $footer = view(config('settings.theme').'.admin.footer')->render();
        $this->vars = array_add($this->vars, 'footer', $footer);

        return view($this->template)->with($this->vars);
    }

    public function getMenu() {

        //$menu->add('Статьи', ['route' => 'admin.articles.index']);
        return Menu::make('adminMenu', function($menu) {
            $menu->add('Статьи', ['route' =>'admin.articles.index']);

            $menu->add('Портфолио', ['route' =>'admin.articles.index']);
            $menu->add('Меню', ['route' =>'admin.menus.index']);
            $menu->add('Пользователи', ['route' =>'admin.users.index']);
            $menu->add('Привилегии', ['route' =>'admin.permissions.index']);
        });
    }
}
