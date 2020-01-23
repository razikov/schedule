<?php
namespace app\models;

use yii\db\ActiveRecord;
use Yii;

class InfoThemes extends ActiveRecord
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
        
    public static function getDb()
    {
        return \Yii::$app->get('schedule_info');
    }

    public static function tableName()
    {
        return '{{%themes}}';
    }

}