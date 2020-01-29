<?php

namespace app\models;

use app\components\Token;
use Yii;
use yii\base\Model;
use yii\helpers\VarDumper;

class ChangePasswordForm extends Model
{
    public $password;
    public $passwordVerify;
    public $token;

    public function rules()
    {
        return [
            [['password', 'passwordVerify'], 'required'],
            ['password', 'string', 'min' => 4],
            ['passwordVerify', 'compare', 'compareAttribute' => 'password'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'password' => \Yii::t('app', 'Новый пароль'),
            'passwordVerify' => \Yii::t('app', 'Повторите пароль'),
        ];
    }

    /**
     * @return bool
     */
    public function changePassword()
    {
        if ($this->validateToken() && $this->validate(null, false) && ($user_id = Token::data($this->token))) {
            /** @var User $user */
            if ($user = User::findOne($user_id)) {
                $user->password_hash = Yii::$app->security->generatePasswordHash($this->password);
//                $user->auth_key = Yii::$app->security->generateRandomString();
                if ($user->save() && Token::delete($this->token)) {
                    return true;
                }
                Yii::error(VarDumper::dumpAsString($user));
            } else {
                Yii::error(Yii::t('app', 'Пользователь не найден.'));
            }
        }
        return false;
    }

    public function validateToken()
    {
        if (Token::data($this->token) === false) {
            $this->addError('password', Yii::t('app', 'Токен не найден'));
            return false;
        }
        return true;
    }
}
