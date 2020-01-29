<?php
namespace app\models;

use yii\data\ActiveDataProvider;
use DateTime;
use Yii;

class ReferenceCourseClassroomSearch extends ReferenceCourseClassroom
{

    public function rules()
    {
        return [
            [['id_course', 'dateAt', 'startTimeAt', 'classroom'], 'safe'],
        ];
    }
    
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
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
                        'date' => SORT_ASC,
                        'start_time' => SORT_ASC,
                    ]
                ],
            ]
        );
    }
    
    public function searchQuery($params)
    {
        $this->load($params);
        
        $tableName = static::tableName();
        $courseTable = InfoCourse::tableName();
        $query = static::find()
            ->select([
                $tableName.'.*',
            ])
            ->andFilterWhere([$tableName.'.classroom' => $this->classroom])
            ->andFilterWhere([$tableName.'.date' => $this->date])
            ->andFilterWhere([$tableName.'.start_time' => $this->start_time])
            ->andFilterWhere([$tableName.'.id_course' => $this->id_course])
        ;
        
        return $query;
    }

}