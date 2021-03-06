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
        if(!Gate::denies('create', $this->model)) {
            abort(403, 'Добавление пользователя запрещено');
        }

        $data = $request->all();
        //dd($request->all());
        $user = $this->model->create([
        //$user = User::create([  // можно так
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

    public function updateUser($request, $user) {

        if(!Gate::denies('edit', $this->model)) {
            abort(403, 'Сохранение пользователя запрещено');
        }
        $data = $request->all();

        if(isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            // этого else у автора курса небыло...шла ошибка типа ...пустой пароль
            //$oldpass = $this->model->where('id',$user->id)->first(['email','password']);//шоб видеть что приходит
            $oldpass = $this->model->where('id',$user->id)->first(['password']);
            $data['password'] = $oldpass['password'];
        }

        $user->fill($data)->update();
        $user->roles()->sync([$data['role_id']]);

        return ['status' => 'Пользователь изменен'];
    }

    public function deleteUser($user) {

        if(!Gate::denies('edit', $this->model)) {
            abort(403, 'Удаление пользователя запрещено');
        }

        $user->roles()->detach();

        if($user->delete()) {
            return ['status' => 'Пользователь удален'];
        }
    }

}