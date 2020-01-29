<?php

namespace app\components;

class Token
{
    const EXPIRE = 86400;

    /**
     * @param $user_id
     * @return bool
     */
    public static function createToken($user_id)
    {
        $token = \Yii::$app->security->generateRandomString(8);
        if (static::getCache()->add($token, $user_id, self::EXPIRE)) {
            return $token;
        }
        return false;
    }

    protected static function getCache()
    {
        return \Yii::$app->cache;
    }

    public static function data($token)
    {
        return static::getCache()->get($token);
    }

    public static function delete($token)
    {
        static::getCache()->delete($token);
        return true;
    }
}
