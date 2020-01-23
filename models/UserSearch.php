<?php

namespace app\models;

use app\helpers\Helper;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\db\Expression;
use yii\db\Query;
use yii\helpers\ArrayHelper;

class UserSearch extends User
{
    public $roles;
    
    public function init()
    {
        parent::init();
        $this->status = self::STATUS_ACTIVE;
    }

    public function formName()
    {
        return '';
    }

    public function rules(): array
    {
        return [
            [
                [
                    'id',
                    'first_name',
                    'middle_name',
                    'last_name',
                    'email',
                    'roles',
                    'status',
                ],
                'safe',
            ],
        ];
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(
            parent::attributeLabels(),
            [
                'roles' => \Yii::t('app', 'Роль'),
                'email' => \Yii::t('app', 'Электронная почта'),
            ]
        );
    }

    public function search($params = [])
    {
        $this->load($params);

        return new ActiveDataProvider([
            'query' => $this->getSearchQuery(),
            'sort' => [
                'attributes' => [
                    'id',
                    'email',
                    'created_at',
                    'fullName' => [
                        'asc' => ['last_name' => SORT_ASC, 'first_name' => SORT_ASC, 'middle_name' => SORT_ASC],
                        'desc' => ['last_name' => SORT_DESC, 'first_name' => SORT_DESC, 'middle_name' => SORT_DESC],
                    ],
                ],
            ],
        ]);
    }

    public function getSearchQuery()
    {
        $query = static::find();
        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['status' => $this->status]);
        $query->andFilterWhere(['like', 'first_name', $this->first_name]);
        $query->andFilterWhere(['like', 'middle_name', $this->middle_name]);
        $query->andFilterWhere(['like', 'last_name', $this->last_name]);
        $query->andFilterWhere(['like', 'email', $this->email]);
        if ($this->roles) {
            $query->andWhere(['role' => $this->roles]);
        }
        return $query;
    }
    
}
