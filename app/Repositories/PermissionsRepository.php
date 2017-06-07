<?php

namespace Corp\Repositories;

use Corp\Permission;
use Gate;

class PermissionsRepository extends Repository {

    public function __construct(Permission $permission) {
        $this->model = $permission;
    }

    public function changePermissions($request) {
        if(Gate::denies('change', $this->model)) {
            abort(403,'Нет прав на изменение разрешений (PermRepo)');
        }
    }
}