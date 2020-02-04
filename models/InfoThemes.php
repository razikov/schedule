<?php
namespace app\models;

use yii\db\ActiveRecord;
use Yii;

class InfoThemes extends InfoCommon
{
    
    public function rules()
    {
        return [
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'ID' => Yii::t('app', '#'),
            'Name' => Yii::t('app', 'Название'),
        ];
    }

    public static function tableName()
    {
        return self::getDbName() . '.{{%themes}}';
    }

}