<?php

namespace app\rbac;

use app\models\User;
use yii\rbac\Rule;

class RoleRule extends Rule
{
    public $name = 'RoleRule';

    public function execute($user, $item, $params)
    {
        $user = User::findIdentity($user);

        return $user && $user->role == $item->name;
    }
}
