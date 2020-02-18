<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\caching\CacheInterface;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\validators\DateValidator;
use yii\web\IdentityInterface;

/**
 * 
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 2;

    const ROLE_ADMIN = 'admin';
    const ROLE_ADMIN_SCHEDULE = 'admin-schedule';
    const ROLE_USER_SCHEDULE = 'user-schedule';

    const USER_LIST = 'user-list';
    const USER_CREATE = 'user-create';
    const USER_UPDATE = 'user-update';
    
    const SCHEDULE_COURSES_LIST = 'schedule-courses-list';
    const SCHEDULE_THEMES_LIST = 'schedule-themes-list';
    const SCHEDULE_CLASSROOM_MAP = 'schedule-classroom-map';
    const SCHEDULE_RESERVATION_VIEW = 'schedule-reservation-view';
    const SCHEDULE_RESERVATION_CREATE = 'schedule-reservation-create';
    const SCHEDULE_RESERVATION_UPDATE = 'schedule-reservation-update';
    const SCHEDULE_RESERVATION_DELETE = 'schedule-reservation-delete';
    

    public static function tableName(): string
    {
        return 'user';
    }

    public static function find()
    {
        return new UserQuery(get_called_class());
    }

    public static function findIdentity($id)
    {
        /** @var CacheInterface $cache */
        $cache = \Yii::$app->arrayCache;

        return $id ? $cache->getOrSet(
            'user:'.$id,
            function () use ($id) {
                return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
            }
        ) : null;
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        $user = static::findOne(['access_token' => $token, 'status' => self::STATUS_ACTIVE]);
        if ($user) {
            \Yii::$app->arrayCache->set('user:'.$user->id, $user);
        }

        return $user;
    }

    public static function findByEmailAndPassword($email, $password)
    {
        if ($email && $password && ($user = static::findByEmail($email)) && $user->validatePassword($password)) {
            return $user;
        }

        return null;
    }

    /**
     * @param string $email
     * @return User
     */
    public static function findByEmail($email)
    {
        $user = static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
        if ($user) {
            \Yii::$app->arrayCache->set('user:'.$user->id, $user);
        }

        return $user;
    }

    public function validatePassword($password)
    {
        return \Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public static function getRoleList(): array
    {
        return [
            self::ROLE_ADMIN => \Yii::t('app', 'Администратор'),
            self::ROLE_ADMIN_SCHEDULE => \Yii::t('app', 'Администратор расписания'),
            self::ROLE_USER_SCHEDULE => \Yii::t('app', 'Пользователь расписания'),
        ];
    }

    public function rules(): array
    {
        return [
            ['email', 'required'],
            ['email', 'email'],
            [['first_name', 'middle_name', 'last_name', 'email'], 'string', 'max' => 255],
            ['last_activity_at', 'date', 'type' => DateValidator::TYPE_DATETIME, 'format' => 'Y-m-d H:m:s'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => array_keys(static::getStatusList())],
        ];
    }

    public static function getStatusList(): array
    {
        return [
            self::STATUS_ACTIVE => Yii::t('app', 'Активный'),
            self::STATUS_DELETED => Yii::t('app', 'Удален'),
        ];
    }

    public static function getListByRole($role, array $options = [])
    {
        $query = self::find()
            ->where(['role' => $role]);

        if (isset($options['order'])) {
            $query->orderBy($options['order']);
        }

        return $query->all();
    }

    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app', 'ID'),
            'created_at' => \Yii::t('app', 'Создан'),
            'updated_at' => \Yii::t('app', 'Изменен'),
            'last_activity_at' => \Yii::t('app', 'Время последней активности'),
            'first_name' => \Yii::t('app', 'Имя'),
            'middle_name' => \Yii::t('app', 'Отчество'),
            'last_name' => \Yii::t('app', 'Фамилия'),
            'status' => \Yii::t('app', 'Статус'),
            'role' => \Yii::t('app', 'Роль'),
            'fullName' => Yii::t('app', 'ФИО'),
        ];
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
            ],
        ];
    }

    public function setLastActivity()
    {
        static::updateAll(['last_activity_at' => date('Y-m-d H:i:s')], ['id' => $this->id]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->id;
    }

    public function validateAuthKey($authKey)
    {
        return $this->id == $authKey;
    }

    public function getFullName()
    {
        return implode(' ', [$this->last_name, $this->first_name, $this->middle_name]);
    }

    public function getRoleName()
    {
        return ArrayHelper::getValue(self::getRoleList(), $this->role);
    }

//    public function generateAccessToken()
//    {
//        $this->access_token = Yii::$app->security->generateRandomString(128);
//        $this->save(false, ['access_token']);
//    }

//    public function fields()
//    {
//        $result = parent::fields();
//
//        return array_diff_key($result, array_flip(['password_hash', 'auth_key']));
//    }
    
    public function changePassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
//        $this->auth_key = Yii::$app->security->generateRandomString();
//        $this->password_changed_at = date('Y-m-d H:i:s');
    }
}
