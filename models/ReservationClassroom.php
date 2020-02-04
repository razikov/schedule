<?php
namespace app\models;

use yii\db\ActiveRecord;
use Yii;
use DateTime;

class ReservationClassroom extends ActiveRecord
{
    public $_courseTheme;

    public function setCompositeKey($id_course, $id_order)
    {
        $courseThemes = InfoCourseThemes::findOne([
            'IDCourse' => $id_course,
            'Order1' => $id_order,
        ]);
        if (!$courseThemes) {
//            throw "Тема курса не найдена";
            return null;
        } else {
            $this->id_course = $id_course;
            $this->id_order = $id_order;
            $this->_courseTheme = $courseThemes;
        }
        $this->date_at = $courseThemes->Date1;
        $this->startTime = $courseThemes->time;
        $this->endTime = $courseThemes->endTime;
        return $this;
    }
    
    public static function generateId($id_course, $id_order)
    {
        return implode('-', [$id_course, $id_order]);
    }
    
    public function getCompositeKey()
    {
        return [
            'IDCourse' => $this->id_course,
            'Order1' => $this->id_order,
        ];
    }
    
    public function afterFind()
    {
        $courseThemes = InfoCourseThemes::findOne([
            'IDCourse' => $this->id_course,
            'Order1' => $this->id_order,
        ]);
        if ($courseThemes) {
            $this->_courseTheme = $courseThemes;
        }
    }

    public function rules()
    {
        return [
            [['id_course', 'id_order', 'classroom', 'date_at', 'time_start_at'], 'required'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '#'),
            'divisionName' => Yii::t('app', 'Подразделение'),
            'courseName' => Yii::t('app', 'Курс'),
            'themeName' => Yii::t('app', 'Занятие'),
            'classroom' => Yii::t('app', 'Аудитория'),
            'date_at' => Yii::t('app', 'Дата'),
            'date' => Yii::t('app', 'Дата'),
            'time_start_at' => Yii::t('app', '(Время) С'),
            'startTime' => Yii::t('app', '(Время) С'),
            'time_end_at' => Yii::t('app', '(Время) По'),
            'endTime' => Yii::t('app', '(Время) По'),
        ];
    }
    
    public function getThemeName()
    {
        return \yii\helpers\ArrayHelper::getValue($this, ['_courseTheme', 'theme', 'Name'], 'Название темы не найдено');
    }
    
    public function getCourseName()
    {
        return \yii\helpers\ArrayHelper::getValue($this, ['_courseTheme', 'course', 'Name'], 'Название курса не найдено');
    }
    
    public function getDivisionName()
    {
        return \yii\helpers\ArrayHelper::getValue($this, ['_courseTheme', 'course', 'division', 'Name'], 'Название структурного подразделения не найдено');
    }
    
    public function setDate($value)
    {
        $this->date_at = DateTime::createFromFormat('d.m.Y', $value)->format('Y-m-d');
        return $this;
    }
    
    public function getDate()
    {
        return $this->date_at ? DateTime::createFromFormat('Y-m-d', $this->date_at)->format('d.m.Y') : null;
    }
    
    public function setStartTime($value)
    {
        $this->time_start_at = DateTime::createFromFormat('H:i', $value)->format('H:i:s');
        return $this;
    }
    
    public function getStartTime()
    {
        return $this->time_start_at ? DateTime::createFromFormat('H:i:s', $this->time_start_at)->format('H:i') : null;
    }
    
    public function setEndTime($value)
    {
        $this->time_end_at = DateTime::createFromFormat('H:i', $value)->format('H:i:s');
        return $this;
    }
    
    public function getEndTime()
    {
        return $this->time_end_at ? DateTime::createFromFormat('H:i:s', $this->time_end_at)->format('H:i') : null;
    }

    public static function tableName()
    {
        return '{{%rasp_reservation}}';
    }

}