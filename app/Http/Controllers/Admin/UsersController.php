<?php

namespace Corp\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Corp\Http\Controllers\Controller;

use Corp\Repositories\UsersRepository;
use Corp\Repositories\RolesRepository;

use Gate;
use Corp\User;

class UsersController extends AdminController
{

    protected $us_rep;
    protected $rol_rep;

    public function __construct(RolesRepository $rol_rep, UsersRepository $us_rep)
    {
        parent::__construct();

        if(!Gate::denies('EDIT_USERS')) {
            abort(403,'Нет прав менять пользователей (UsersController)');
        }

        $this->us_rep = $us_rep;
        $this->rol_rep = $rol_rep;

        $this->template = env('THEME').'.admin.users';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $this->title = 'Менеджер пользователей';

        $users = $this->us_rep->get();
        //dd($users);

        $this->content = view(env('THEME').'.admin.users_content')
            ->with(['users' => $users])->render();

        return $this->renderOutput();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $this->title = 'Новый пользователь';

        $roles = $this->getRoles()->reduce(function($returnRoles, $role) {
            $returnRoles[$role->id] = $role->name;
            return $returnRoles;
        }, []);
        dd($roles);
    }

    public function getRoles() {
        return \Corp\Role::all();
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
