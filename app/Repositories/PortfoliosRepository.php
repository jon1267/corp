<?php

namespace Corp\Repositories;

use Corp\Portfolio;
use Gate;

class PortfoliosRepository extends Repository
{
    public function __construct(Portfolio $portfolio) {
        $this->model = $portfolio;
    }

    public function one($alias, $attr = []) {
        $portfolio = parent::one($alias, $attr);

        if($portfolio && $portfolio->img) {
            $portfolio->img = json_decode($portfolio->img);
        }
        return $portfolio;
    }

    public function addPortfolio($request) {
        /*if(Gate::denies('save', $this->model)) {
            abort(403, 'Нет прав добавлять репозиторий');
        }*/
        $data = $request->except('_token', 'img');

        if(empty($data)) {
            return ['error' => 'Нет данных'];
        }
        if(empty($data['alias'])) {
            $data['alias'] = $this->transliterate($data['title']);
        }
        dd($data);
    }


}