<?php
namespace app\models;

use yii\db\ActiveRecord;
use Yii;
use yii\helpers\ArrayHelper;

class InfoCourse extends InfoCommon
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
    
    public function getClassrooms()
    {
//        return ReferenceCourseClassroom::findOne([
//            'id_course' => $this->ID,
//        ]);
        return $this->hasMany(ReferenceCourseClassroom::class, ['id_course' => 'ID']);
    }
    
    public function getClassroom()
    {
//        return ReferenceCourseClassroom::findOne([
//            'id_course' => $this->ID,
//        ]);
        return $this->hasOne(ReferenceCourseClassroom::class, ['id_course' => 'ID']);
    }

    public static function tableName()
    {
        return self::getDbName() . '.{{%courses}}';
    }

}