<?php

namespace Corp\Repositories;

use Corp\Menu;
use Gate;

class MenusRepository extends Repository {

    public function __construct(Menu $menu) {
        $this->model = $menu;
    }

    public function addMenu($request) {
        if(Gate::denies('save', $this->model)) {
            abort(403, 'Добавление меню запрещено');
        }
        $data = $request->only('type','title','parent');

        if(empty($data)) return ['error'=>'Нет данных для создания меню'];

        //dd($request->all());

        switch ($data['type']) {
            case 'customLink':
                $data['path'] = $request->input('custom_link');
            break;

            case 'blogLink':
                if($request->input('category_alias')) {
                    if($request->input('category_alias') == 'parent') {
                        $data['path'] = route('articles.index');
                    } else {
                        $data['path'] = route('articlesCat', ['cat_alias'=>$request->input('category_alias')]);
                    }
                } elseif($request->input('article_alias')) {
                    $data['path'] = route('articles.show', ['alias' => $request->input('article_alias')]);
                }
            break;

            case 'portfolioLink':
                if($request->input('filter_alias')) {
                    if($request->input('filter_alias') == 'parent') {
                        $data['path'] = route('portfolios.index');
                    }
                } elseif($request->input('portfolio_alias')) {
                    $data['path'] = route('portfolios.show', ['alias' => $request->input('portfolio_alias')]);
                }
            break;
            // не прошел ни один из кейсов
            /*default :
                return ['error'=>'Невозможно создать меню, нет ссылки'];*/
        }

        unset($data['type']);
        //dd($data);

        // текущий объект модели (Menu) заполняем данными из $data и сохраняем
        // и если все без ошибок - вернем 'status' с сообщением
        if($this->model->fill($data)->save()) {
            return ['status' => 'Ссылка добавлена'];
        }
    }

    public function updateMenu($request, $menu) {
        // тут 'save' надо менять на 'update' и создавать др. разрешение...)
        if(Gate::denies('save', $this->model)) {
            abort(403, 'Сохранение меню запрещено');
        }
        $data = $request->only('type','title','parent');

        if(empty($data)) return ['error'=>'Нет данных для создания меню'];

        //dd($request->all());

        switch ($data['type']) {
            case 'customLink':
                $data['path'] = $request->input('custom_link');
                break;

            case 'blogLink':
                if($request->input('category_alias')) {
                    if($request->input('category_alias') == 'parent') {
                        $data['path'] = route('articles.index');
                    } else {
                        $data['path'] = route('articlesCat', ['cat_alias'=>$request->input('category_alias')]);
                    }
                } elseif($request->input('article_alias')) {
                    $data['path'] = route('articles.show', ['alias' => $request->input('article_alias')]);
                }
                break;

            case 'portfolioLink':
                if($request->input('filter_alias')) {
                    if($request->input('filter_alias') == 'parent') {
                        $data['path'] = route('portfolios.index');
                    }
                } elseif($request->input('portfolio_alias')) {
                    $data['path'] = route('portfolios.show', ['alias' => $request->input('portfolio_alias')]);
                }
                break;
            // не прошел ни один из кейсов
            /*default :
                return ['error'=>'Невозможно создать меню, нет ссылки'];*/
        }

        unset($data['type']);
        //dd($data);

        // текущий объект модели (Menu) заполняем данными из $data и сохраняем
        // и если все без ошибок - вернем 'status' с сообщением
        //if($this->model->fill($data)->save()) { // это из addMenu()
        if($menu->fill($data)->update()) {
            return ['status' => 'Ссылка обновлена'];
        }
    }

    public function deleteMenu($menu) {
        // тут 'save' надо менять на 'delete' и создавать др. разрешение...)
        if(Gate::denies('save', $this->model)) {
            abort(403, 'Удаление меню запрещено');
        }
        if($menu->delete()) {
            return ['status' => 'Ссыка удалена'];
        }
    }

}