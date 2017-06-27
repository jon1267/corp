<?php

namespace Corp\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Corp\Http\Controllers\Controller;

use Corp\Repositories\PortfoliosRepository;

use Corp\Portfolio;
use Gate;


class PortfoliosController extends AdminController
{
    public function __construct(PortfoliosRepository $p_rep)
    {
        parent::__construct();

        // ну тут бы уже нада 'VIEW_ADMIN_PORTFOLIOS'
        if(!Gate::denies('VIEW_ADMIN_ARTICLES')) {
            abort(403, 'Нет прав на просмотр портфолио');
        }
        $this->p_rep = $p_rep;

        $this->template = config('settings.theme').'.admin.portfolios';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $this->title = 'Меннеджер портфолио';
        $portfolios = $this->getPortfolios();

        $this->content = view(config('settings.theme').'.admin.portfolios_content')
            ->with('portfolios', $portfolios)->render();

        return $this->renderOutput();
    }

    public function getPortfolios() {

        return $this->p_rep->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        //if(Gate::denies('save', new Portfolio() )) {
            //abort(403, 'Нет прав на добавление портфолио');

             // тут срабатывает abort(). Чтоб реально проверить право на добавл. portfolio нада:
             // создать политику (php artisan make:policy PortfolioPolicy). В политике
             // \app\Policies\PortfolioPolicy.php создать publ func save(User $user)
             // {return $user->canDo('ADD_PORTFOLIO');} Далее эту политику зарегистрир. в
             // \app\Providers\AuthServiceProvider.php - в массив protected $policies = []
             // добавить чтото типа [...,Portfolio::class => PortfolioPolicy::class,...]
             // См образец видео №32 ~3:00 мин  Я для скрости опускаю...)
        //}
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
