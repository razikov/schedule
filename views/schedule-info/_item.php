<?php
use yii\helpers\Html;

?>

<div class="list-group-item">
    <div class="row">
        <div class="col-md-2">
            <p></p>
            Время: <strong><?= $model->time ?> - <?= $model->endTime ?></strong><br/>
            Аудитория: <strong><?= $model->classroom ? $model->classroom->classroom : "???" ?></strong><br/>
            <!--#: <strong><?= $model->id ?></strong><br/>-->
        </div>
        <div class="col-md-10">
            <h4><strong><?= $model->theme->Name; ?></strong></h4>
            Подразделение: <?= $model->course->division->Name ?><br/>
<!--            Курс: <?= Html::a(
                $model->course->Name, 
                yii\helpers\Url::toRoute(['schedule-info/index', 'InfoCourseSearch[ID]' => $model->course->ID])
            )?><br/>-->
            Курс: <?= $model->course->Name ?><br/>
            Преподаватель: <strong><?= $model->teacher->fullName; ?></strong><br/>
        </div>
    </div>
</div>