<?php
namespace app\models;

use yii\data\ActiveDataProvider;
use DateTime;
use Yii;

class InfoCourseThemesSearch extends InfoCourseThemes
{
    public $idCourseDivision;
    public $themeName;
    public $courseName;

    public function rules()
    {
        return [
            [['IDCourse', 'IDTheme', 'IDTeacher', 'dateAt', 'idCourseDivision', 'themeName', 'courseName'], 'safe'],
        ];
    }
    
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'dateAt' => Yii::t('app', 'Дата'),
            'idCourseDivision' => Yii::t('app', 'Подразделение'),
            'themeName' => Yii::t('app', 'Название занятия'),
            'courseName' => Yii::t('app', 'Название курса'),
        ]);
    }
    
    public function search($params)
    {
        $query = $this->searchQuery($params);
        
        return new ActiveDataProvider(
            [
                'query' => $query,
                'sort' => [
                    'defaultOrder' => [
                        'Date1' => SORT_ASC,
                        'Time1' => SORT_ASC,
                    ]
                ],
            ]
        );
    }
    
    public function getID()
    {
        return sprintf("%s-%s", $this->IDCourse, $this->Order1);
    }
    
    public function setDateAt($value)
    {
        if ($value) {
            $this->Date1 = DateTime::createFromFormat('d.m.Y', $value)->format('Y-m-d');
        }
        return $this;
    }
    
    public function getDateAt()
    {
        if ($this->Date1) {
            return DateTime::createFromFormat('Y-m-d', $this->Date1)->format('d.m.Y');
        }
        return null;
    }
    
    public function searchQuery($params)
    {
        $this->load($params);
        
        $tableName = static::tableName();
        $themeTable = InfoThemes::tableName();
        $courseTable = InfoCourse::tableName();
        $query = static::find()
            ->select([
                $tableName.'.*',
            ])
            ->joinWith(['course', 'theme'])
            ->andFilterWhere([$tableName.'.IDCourse' => $this->IDCourse])
            ->andFilterWhere([$tableName.'.IDTeacher' => $this->IDTeacher])
            ->andFilterWhere([$tableName.'.Date1' => $this->Date1])
            ->andFilterWhere([$courseTable.'.IDDivision' => $this->idCourseDivision])
            ->andFilterWhere(['like', $courseTable.'.Name', $this->courseName])
            ->andFilterWhere(['like', $themeTable.'.Name', $this->themeName])
        ;
        
        return $query;
    }

}