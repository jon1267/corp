<?php

namespace Corp\Http\Controllers;

use Illuminate\Http\Request;
use Corp\Repositories\PortfoliosRepository;

class PortfolioController extends SiteController
{
    //
    public function __construct(PortfoliosRepository $p_rep)
    {
        parent::__construct(new \Corp\Repositories\MenusRepository(new \Corp\Menu));

        $this->p_rep = $p_rep;

        $this->template = env('THEME').'.portfolios';
    }

    public function index()
    {
        //

        $this->title = 'Портфолио';
        $this->keywords = 'keywords for portfolio';
        $this->meta_desc = 'meta_desc for portfolio';

        $portfolios = $this->getPortfolios();
        //dd($portfolios);

        $content = view(env('THEME').'.portfolios_content')->with('portfolios', $portfolios)->render();
        $this->vars = array_add($this->vars,'content', $content);

        return $this->renderOutput();
    }

    public function getPortfolios($take = false, $paginate = true) {
        $portfolios = $this->p_rep->get('*', $take, $paginate);
        if($portfolios) {
            $portfolios->load('filter');
        }

        return $portfolios;
    }

    public function show($alias) {

        $portfolio = $this->p_rep->one($alias);

        $this->title = $portfolio->title;
        $this->keywords = $portfolio->keywords;
        $this->meta_desc = $portfolio->meta_desc;

        $content = view(env('THEME').'.article_content')->with('article', $article)->render();
        $this->vars = array_add($this->vars, 'content', $content);

        $portfolios = $this->getPortfolios(config('settings.other_portfolios'), false);


        return $this->renderOutput();
    }

}
