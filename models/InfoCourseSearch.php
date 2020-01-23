<?php
namespace app\models;

use yii\db\ActiveRecord;
use yii\data\ActiveDataProvider;
use DateTime;
use Yii;

class InfoCourseSearch extends InfoCourse
{
    
    public $date;

    public function rules()
    {
        return [
            [['ID', 'Name', 'IDDivision', 'dateAt'], 'safe'],
        ];
    }
    
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'dateAt' => Yii::t('app', 'Дата'),
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
                        'StartDate' => SORT_DESC,
                    ]
                ],
            ]
        );
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
    
    public function searchQuery($params)
    {
        $this->load($params);
        
        $tableName = static::tableName();
        $query = static::find()
            ->select([
                $tableName.'.*',
            ])
            ->andFilterWhere([$tableName.'.ID' => $this->ID])
            ->andFilterWhere([$tableName.'.IDDivision' => $this->IDDivision])
            ->andFilterWhere(['like', $tableName.'.Name', $this->Name])
            ->andFilterWhere(['<=', $tableName.'.StartDate', $this->date])
            ->andFilterWhere(['>=', $tableName.'.EndDate', $this->date])
        ;
//        var_dump($query->createCommand()->getRawSql());exit;
//        var_dump($query->limit(10)->all());exit;
        return $query;
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