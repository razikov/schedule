<?php
namespace app\models;

use yii\db\ActiveRecord;
use Yii;
use yii\helpers\ArrayHelper;

class InfoCommon extends ActiveRecord
{
    
    public static function getDb()
    {
        return \Yii::$app->get('schedule_info');
    }
    
    protected static function getDsnAttribute($name, $dsn)
    {
        if (preg_match('/' . $name . '=([^;]*)/', $dsn, $match)) {
            return $match[1];
        } else {
            return null;
        }
    }
    
    protected static function getDbName()
    {
        $name = 'dbname';
        $dsn = self::getDb()->dsn;
        return self::getDsnAttribute($name, $dsn);
    }

}