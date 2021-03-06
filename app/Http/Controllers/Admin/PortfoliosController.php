<?php

namespace Corp\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Corp\Http\Requests\PortfolioRequest;
use Corp\Http\Controllers\Controller;

use Corp\Repositories\PortfoliosRepository;
use Corp\Filter;
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
        //if(Gate::denies('save', new Portfolio() )) {
            //abort(403, 'Нет прав на добавление портфолио');

            // тут срабатывает abort(). Чтоб реально проверить право на добавл. portfolio нада:
            // создать политику (php artisan make:policy PortfolioPolicy). В политике
            // \app\Policies\PortfolioPolicy.php создать public function save(User $user)
            // {return $user->canDo('ADD_PORTFOLIO');} Далее эту политику зарегистрир. в
            // \app\Providers\AuthServiceProvider.php - в массив protected $policies = []
            // добавить чтото типа [...,Portfolio::class => PortfolioPolicy::class,...]
            // Еще в тбл permissions добавить name = 'ADD_PORTFOLIO' а где ADD там и UPD..,DEL...
            // См образец видео №32 ~3:00 мин  Я для скрости опускаю...)
        //}

        $this->title = 'Добавить новое портфолио';

        $filters = Filter::select(['id', 'title', 'alias'])->get();
        //dd($filters);
        $lists =[];
        foreach ($filters as $filter) {
            // вот же жворняжка! так не работает, 2стр. а ниже OK !!!
            //$lists[$filter->id] = $filter->title;
            $lists[$filter->alias] = $filter->title;
        }
        //dd($lists);

        $this->content = view(config('settings.theme').'.admin.portfolios_create_content')->with('filters',$lists)->render();

        return $this->renderOutput();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PortfolioRequest $request)
    {
        //dd($request);
        $result = $this->p_rep->addPortfolio($request);
        if(is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }
        return redirect('/admin')->with($result);
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
    //public function edit($id)
    //public function edit(Portfolio $portfolio)
    public function edit($alias)

    {
        $portfolio = Portfolio::where('alias', $alias)->first();
        //dd($portfolio);
        /*if(!Gate::denies('edit', new Portfolio())) {
            abort(403, 'Нет прав добавлять статьи и портф.');
        }*/
        $portfolio->img = json_decode($portfolio->img);

        $filters = Filter::select(['id', 'title', 'alias'])->get();
        //dd($filters);
        $lists =[];
        foreach ($filters as $filter) {
            // вот же жворняжка! так не работает, 2стр. а ниже OK !!!
            //$lists[$filter->id] = $filter->title;
            $lists[$filter->alias] = $filter->title;
        }
        //dd($lists);
        $this->title = 'Редактируем портфолио - '.$portfolio->title;

        $this->content = view(config('settings.theme').'.admin.portfolios_create_content')
            ->with(['filters' => $lists, 'portfolio' => $portfolio])
            ->render();

        return $this->renderOutput();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //public function update(Request $request, $id)
    public function update(PortfolioRequest $request, $alias)
    {
        // не нормально отрабатывает при обновл. поля алиас...если его не трогать - ОК.
        // ну оно и понятно - по алиасу отыскивается статья, потому он вместо парам алиас
        // сделал Article $article
        $portfolio = Portfolio::where('alias', $alias)->first();

        $result = $this->p_rep->updatePortfolio($request, $portfolio);
        if(is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }
        return redirect('/admin')->with($result);
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
