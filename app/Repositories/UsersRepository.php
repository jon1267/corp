<?php
namespace Corp\Repositories;

use Corp\User;
use Config;
use Gate;

class UsersRepository extends Repository {

    public function __construct(User $user) {
        $this->model = $user;
    }

    public function addUser($request) {
        if(\Gate::denies('create', $this->model)) {
            abort(403, 'Добавление пользователя запрещено');
        }

        $data = $request->all();
        //dd($request->all());
        $user = $this->model->create([
            'name' => $data['name'],
            'login' => $data['login'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
        //dd($user);
        if($user) {
            $user->roles()->attach($data['role_id']);
            //dd($user);
        }
        return ['status' => 'Пользователь добавлен'];
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