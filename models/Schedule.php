<?php
namespace app\models;

use yii\base\Model;

class Schedule
{
    
    public static function create($date)
    {
        $query = (new \yii\db\Query())
            ->select(
                [
                    'd.Name as dname',
                    'c.Name as cname',
                    'c.ID as cid',
                    't.Name as tname',
                    (new \yii\db\Expression("CONCAT_WS('-',cs.IDCourse,cs.Order1) as tid")),
                    (new \yii\db\Expression("CONCAT_WS(' ',teacher.Surname,teacher.Name,teacher.Patronymic) as teacher")),
                    'cs.Time1',
                    'cs.LectureHours',
                    'cs.PracticalHours',
                    'cs.subgroup',
                    'rr.classroom',
                ]
            )
            ->from(\app\models\InfoCourseThemes::tableName() . ' cs')
            ->leftJoin(InfoCourse::tableName() . ' c', 'c.ID = cs.IDCourse')
            ->leftJoin(\app\models\InfoDivision::tableName() . ' d', 'd.ID = c.IDDivision')
            ->leftJoin(\app\models\InfoThemes::tableName() . ' t', 't.ID = cs.IDTheme')
            ->leftJoin(\app\models\InfoTeacher::tableName() . ' teacher', 'teacher.ID = cs.IDTeacher')
            ->leftJoin(\app\models\ReservationClassroom::tableName() . ' rr', 'rr.id_course = cs.IDCourse and rr.id_order = cs.Order1')
            ->where([
                'cs.Date1' => $date,
            ])
            ->orderBy(['c.Name' => SORT_ASC, 'cs.Time1' => SORT_ASC])
            ;
        
        $getTime = function ($time)
        {
            $timeMins = $time;
            $hours = floor($timeMins / 60);
            $mins = $timeMins - ($hours * 60);
            return sprintf("%02d:%02d", $hours, $mins);
        };

        $getEndTime = function ($time, $duration)
        {
            $timeMins = $time + $duration;
            $hours = floor($timeMins / 60);
            $mins = $timeMins - ($hours * 60);
            return sprintf("%02d:%02d", $hours, $mins);
        };
        
        $items = [];
        foreach ($query->all() as $key => $item) {
            $item = (object)$item;
            $item->key = $key;
            
            $_time = floor($item->Time1 / 6000); // мс в минуте
            $_duration = ($item->LectureHours + $item->PracticalHours) * 60;
            $item->time = $getTime($_time);
            $item->endTime = $getEndTime($_time, $_duration);
            if (!isset($items[$item->cid])) {
                $items[$item->cid]['divisionName'] = $item->dname;
                $items[$item->cid]['courseName'] = $item->cname;
                $items[$item->cid]['items'][$item->tid] = $item;
                $items[$item->cid]['out'] = '';
            } else {
                $items[$item->cid]['items'][$item->tid] = $item;
            }
            if ($item->classroom == \app\models\Classroom::OUTSIDE_ROOM) {
                $items[$item->cid]['out'] = '<span class="glyphicon glyphicon-star text-info" aria-hidden="true"></span>';
            }
        }
        
        return $items;
    }

}