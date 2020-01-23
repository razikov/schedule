<?php

namespace app\models;

use Yii;

class UserForm extends User
{
    public $password;
    public $passwordVerify;
    public $sendEmail = 0;

    public function attributeLabels()
    {
        return array_merge(
            parent::attributeLabels(),
            [
                'password' => \Yii::t('app', 'Пароль'),
                'passwordVerify' => \Yii::t('app', 'Повторите пароль'),
                'email' => \Yii::t('app', 'E-mail'),
            ]
        );
    }

    public function rules(): array
    {
        return [
            [['first_name', 'middle_name', 'last_name', 'email'], 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique'],
            [['first_name', 'middle_name', 'last_name', 'email'], 'string', 'max' => 255],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => array_keys(static::getStatusList())],
            [
                ['password', 'passwordVerify'],
                'required',
                'when' => function () {
                    return $this->isNewRecord;
                },
            ],
            ['password', 'safe'],
            ['passwordVerify', 'compare', 'compareAttribute' => 'password'],
            ['role', 'required'],
            ['role', 'in', 'range' => array_keys(static::getRoleList())],
            ['sendEmail', 'boolean'],
            
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if ($this->sendEmail) {
            $result = $this->mailer
                ->compose('createUser', ['user' => $this])
                ->setFrom(Yii::$app->params['adminEmail'])
                ->setTo($this->email)
                ->setSubject(\Yii::t('app', 'Ваши данные для авторизации'))
                ->send();
            if ($result) {
                \Yii::info($this->email, 'mass-password-emails');
            }
        }
    }

    public function afterValidate()
    {
        parent::afterValidate();
        if ($this->hasErrors()) {
            return;
        }
        if ($this->password) {
            $this->changePassword($this->password);
        }
    }
}
