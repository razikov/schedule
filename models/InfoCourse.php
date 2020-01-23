<?php
namespace app\models;

use yii\db\ActiveRecord;
use Yii;
use yii\helpers\ArrayHelper;

class InfoCourse extends ActiveRecord
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
            'IDDivision' => Yii::t('app', 'Подразделение'),
            'Name' => Yii::t('app', 'Название'),
            'StartDate' => Yii::t('app', 'Дата с'),
            'EndDate' => Yii::t('app', 'Дата по'),
        ];
    }
    
    public static function getList()
    {
        $query = static::find()->all();
        return ArrayHelper::map($query, 'ID', 'Name');
    }
    
    public function getDivision()
    {
        return $this->hasOne(InfoDivision::class, ['ID' => 'IDDivision']);
    }
    
    public function getCourseThemes()
    {
        return $this->hasMany(InfoCourseThemes::class, ['IDCourse' => 'ID']);
    }
    
    public static function getDb()
    {
        return \Yii::$app->get('schedule_info');
    }

    public static function tableName()
    {
        return '{{%courses}}';
    }

}