<?php

namespace app\models;

use app\components\Token;
use Yii;
use yii\base\Model;
use yii\helpers\VarDumper;

class RestorePasswordForm extends Model
{
    public $email;
    public $verifyCode;

    public function rules()
    {
        return [
            [['email', 'verifyCode'], 'required'],
            ['email', 'email'],
            [
                'verifyCode',
                'captcha',
                'captchaAction' => 'site/captcha',
            ],
            [
                'email',
                'exist',
                'targetClass' => User::class,
                'targetAttribute' => 'email',
                'message' => Yii::t('app', 'Пользователь с таким e-mail\'ом не найден.'),
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => Yii::t('app', 'E-mail'),
            'verifyCode' => Yii::t('app', 'Код с картинки'),
        ];
    }

    public function sendEmail()
    {
        if ($this->validate()) {
            $user = User::findByEmail($this->email);
            if ($user) {
                if ($token = Token::createToken($user->id)) {
                    return Yii::$app->mailer
                        ->compose('restorePassword', ['token' => $token])
                        ->setSubject(Yii::t('app', 'Восстановление пароля'))
                        ->setFrom(Yii::$app->params['adminEmail'])
                        ->setTo($this->email)
                        ->send();
                } else {
                    Yii::error('Ошибка создания токена. '.VarDumper::dumpAsString($token));
                }
            } else {
                Yii::error(Yii::t('app', 'E-mail не найден'));
            }
        }

        return false;
    }
}
