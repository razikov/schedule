<?php
namespace app\models;

use yii\base\Model;

class Classroom extends Model
{
    
    public function rules()
    {
        return [];
    }
    
    public function attributeLabels()
    {
        return [];
    }
    
    public static function getList()
    {
        return [
            204 => '204',
            303 => '303',
            311 => '311',
            323 => '323',
            404 => '404',
            406 => '406',
            407 => '407',
            408 => '408',
            409 => '409',
            410 => '410',
            411 => '411',
            412 => '412',
            413 => '413',
            424 => '424',
            425 => '425',
        ];
    }

}