<?php
namespace app\models;

use yii\db\ActiveRecord;
use Yii;
use DateTime;

class ReferenceCourseClassroom extends ActiveRecord
{

    public function rules()
    {
        return [
            [['id_course', 'classroom', 'dateAt'], 'required'],
            [['startTimeAt'], 'safe'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '#'),
            'id_course' => Yii::t('app', 'Курс'),
            'classroom' => Yii::t('app', 'Аудитория'),
            'date' => Yii::t('app', 'Дата'),
            'dateAt' => Yii::t('app', 'Дата'),
            'start_time' => Yii::t('app', 'Время начала'),
            'startTimeAt' => Yii::t('app', 'Время начала'),
        ];
    }
    
    public function getCourse()
    {
        return $this->hasOne(InfoCourse::class, ['ID' => 'id_course']);
    }
    
    public function setDateAt($value)
    {
        $this->date = DateTime::createFromFormat('d.m.Y', $value)->format('Y-m-d');
        return $this;
    }
    
    public function getDateAt()
    {
        return $this->date ? DateTime::createFromFormat('Y-m-d', $this->date)->format('d.m.Y') : null;
    }
    
    public function setStartTimeAt($value)
    {
        $this->start_time = DateTime::createFromFormat('H:i', $value)->format('H:i:s');
        return $this;
    }
    
    public function getStartTimeAt()
    {
        return $this->start_time ? DateTime::createFromFormat('H:i:s', $this->start_time)->format('H:i') : null;
    }
    
    public static function tableName()
    {
        return '{{%ref_course_classroom}}';
    }

}