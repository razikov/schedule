<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use app\models\User;
use app\rbac\RoleRule;
use app\models\UserForm;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();
        
        $roleRule = new RoleRule();
        $auth->add($roleRule);
        
        $listUser = $auth->createPermission(User::USER_LIST);
        $auth->add($listUser);
        $createUser = $auth->createPermission(User::USER_CREATE);
        $auth->add($createUser);
        $updateUser = $auth->createPermission(User::USER_UPDATE);
        $auth->add($updateUser);
        
        $scheduleCoursesList = $auth->createPermission(User::SCHEDULE_COURSES_LIST);
        $auth->add($scheduleCoursesList);
        $scheduleThemesList = $auth->createPermission(User::SCHEDULE_THEMES_LIST);
        $auth->add($scheduleThemesList);
        $scheduleClassroomMap = $auth->createPermission(User::SCHEDULE_CLASSROOM_MAP);
        $auth->add($scheduleClassroomMap);
        $scheduleReservationCreate = $auth->createPermission(User::SCHEDULE_RESERVATION_CREATE);
        $auth->add($scheduleReservationCreate);
        $scheduleReservationUpdate = $auth->createPermission(User::SCHEDULE_RESERVATION_UPDATE);
        $auth->add($scheduleReservationUpdate);
        $scheduleReservationDelete = $auth->createPermission(User::SCHEDULE_RESERVATION_DELETE);
        $auth->add($scheduleReservationDelete);

        $admin = $auth->createRole(User::ROLE_ADMIN);
        $admin->ruleName = 'RoleRule';
        $auth->add($admin);
        $adminSchedule = $auth->createRole(User::ROLE_ADMIN_SCHEDULE);
        $adminSchedule->ruleName = 'RoleRule';
        $auth->add($adminSchedule);
        
        $auth->addChild($admin, $createUser);
        $auth->addChild($admin, $updateUser);
        $auth->addChild($admin, $listUser);
        $auth->addChild($admin, $scheduleCoursesList);
        $auth->addChild($admin, $scheduleThemesList);
        $auth->addChild($admin, $scheduleClassroomMap);
        $auth->addChild($admin, $scheduleReservationCreate);
        $auth->addChild($admin, $scheduleReservationUpdate);
        $auth->addChild($admin, $scheduleReservationDelete);
        
        $auth->addChild($adminSchedule, $scheduleCoursesList);
        $auth->addChild($adminSchedule, $scheduleThemesList);
        $auth->addChild($adminSchedule, $scheduleClassroomMap);
        $auth->addChild($adminSchedule, $scheduleReservationCreate);
        $auth->addChild($adminSchedule, $scheduleReservationUpdate);
        $auth->addChild($adminSchedule, $scheduleReservationDelete);
        
        $roles = array_keys($auth->getRoles());
        file_put_contents(\Yii::getAlias('@app/rbac/roles.php'), "<?php\n\nreturn " . \yii\helpers\VarDumper::export($roles) . ";\n");
    }
    
    public function actionCreateAdminUser()
    {
        $model = new UserForm();
        $model->email = $this->prompt('E-mail: ', ['required' => true]);
        $model->password = $model->passwordVerify = $this->prompt('Password: ', ['required' => true]);
        $model->role = User::ROLE_ADMIN;
        $model->save();
    }
}