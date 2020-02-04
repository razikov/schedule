<?php
namespace app\models;

use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use Yii;

class InfoDivision extends InfoCommon
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
    
    public static function getList()
    {
        $query = static::find()->all();
        return ArrayHelper::map($query, 'ID', 'Name');
    }

    public static function tableName()
    {
        return self::getDbName() . '.{{%divisions}}';
    }

}