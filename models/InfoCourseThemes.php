<?php
namespace app\models;

use yii\db\ActiveRecord;
use Yii;

class InfoCourseThemes extends InfoCommon
{
    private $_time;
    private $_duration;
//    public $classroom;
    
    public function afterFind()
    {
        $this->_time = floor($this->Time1 / 6000); // мс в минуте
        $this->_duration = ($this->LectureHours + $this->PracticalHours) * 45;
//        $this->_duration = ($this->LectureHours + $this->PracticalHours) * 60;
//        $this->classroom = ReservationClassroom::findOne([
//            'id_theme' => ReservationClassroom::generateId($this->IDCourse, $this->Order1),
//        ]);
    }
    
    public function rules()
    {
        return [
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'IDCourse' => Yii::t('app', 'Курс'),
            'IDTheme' => Yii::t('app', 'Занятие'),
            'IDTeacher' => Yii::t('app', 'Преподаватель'),
            'Date1' => Yii::t('app', 'Дата'),
            'Time1' => Yii::t('app', 'Время'),
        ];
    }
    
    public function getTeacher()
    {
        return $this->hasOne(InfoTeacher::class, ['ID' => 'IDTeacher']);
    }
    
    public function getCourse()
    {
        return $this->hasOne(InfoCourse::class, ['ID' => 'IDCourse']);
    }
    
    public function getTheme()
    {
        return $this->hasOne(InfoThemes::class, ['ID' => 'IDTheme']);
    }
    
    public function getClassroom()
    {
//        return ReservationClassroom::findOne([
//            'id_theme' => ReservationClassroom::generateId($this->IDCourse, $this->Order1)
//        ]);
        return $this->hasOne(ReservationClassroom::class, ['id_course' => 'IDCourse', 'id_order' => 'Order1']);
    }
    
    public function getTime()
    {
        $timeMins = $this->_time;
        $hours = floor($timeMins / 60);
        $mins = $timeMins - ($hours * 60);
        return sprintf("%02d:%02d", $hours, $mins);
    }
    
    public function getEndTime()
    {
        $timeMins = $this->_time + $this->_duration;
        $hours = floor($timeMins / 60);
        $mins = $timeMins - ($hours * 60);
        return sprintf("%02d:%02d", $hours, $mins);
    }

    public static function tableName()
    {
        return self::getDbName() . '.{{%coursethemes}}';
    }

}