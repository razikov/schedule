<?php
namespace app\models;

use yii\base\Model;

class Classroom extends Model
{
    const OUTSIDE_ROOM = -1;
    const WITHOUT_ROOM = 'without';
    const BIBLIO_ROOM = 'biblio';
    
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
            210 => '210',
            303 => '303',
            311 => '311',
            323 => '323',
            self::BIBLIO_ROOM => 'Читальный зал',
//            404 => '404',
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
            self::WITHOUT_ROOM => '-',
            self::OUTSIDE_ROOM => 'На выезде',
        ];
    }

}