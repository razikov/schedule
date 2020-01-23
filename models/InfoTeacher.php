<?php
namespace app\models;

use yii\db\ActiveRecord;
use Yii;
use yii\helpers\ArrayHelper;

class InfoTeacher extends ActiveRecord
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
            'FullName' => Yii::t('app', 'Имя'),
        ];
    }
    
    public static function getList()
    {
        $query = static::find()->all();
        return ArrayHelper::map($query, 'ID', 'fullName');
    }
    
    public function getDivision()
    {
        return $this->hasOne(InfoDivision::class, ['IDDivision' => 'ID']);
    }
    
    public function getFullName()
    {
        return sprintf("%s %s %s", $this->Surname, $this->Name, $this->Patronymic);
    }
    
    public static function getDb()
    {
        return \Yii::$app->get('schedule_info');
    }

    public static function tableName()
    {
        return '{{%teachers}}';
    }

}