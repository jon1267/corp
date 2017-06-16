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
                    }
                }

            break;

        }

        unset($data['type']);
        //dd($data);

        // текущий объект модели (Menu) заполняем данными из $data и сохраняем
        // и если все без ошибок - вернем 'status' с сообщением
        if($this->model->fill($data)->save()) {
            return ['status' => 'Ссылка добавлена'];
        }
    }

}