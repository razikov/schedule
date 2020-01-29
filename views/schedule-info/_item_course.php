<?php
use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="list-group-item">
    <div class="row">
        <div class="col-md-2">
            <p></p>
            Время: <strong><?= $model->startTimeAt ?></strong><br/>
            Аудитория: <strong><?= $model->classroom ?></strong><br/>
        </div>
        <div class="col-md-10">
            <h4><strong><?= $model->course->Name; ?></strong></h4>
            Подразделение: <?= $model->course->division->Name ?><br/>
            <?= Html::a(
                "Занятия", 
                Url::toRoute(['schedule-info/themes-modal', 'courseId' => $model->course->ID]),
                    ['class' => 'js-show-modal']
            )?><br/>
        </div>
    </div>
</div>