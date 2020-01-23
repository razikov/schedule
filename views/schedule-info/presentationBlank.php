<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\ActiveForm;
use app\widgets\DatePicker;

$this->title = 'Расписание занятий ГОАУ ЯО ИРО';
$formatter = Yii::$app->formatter;
$now = date("d.m.Y");
?>
<div class="alert alert-info">
    Сегодня <?= $formatter->asDate($now, 'full') ?>
</div>

<?= ListView::widget([
    'layout' => "{items}\n",
    'dataProvider' => $dataProvider,
    'itemView' => '_item',
    'options' => [
        'class' => 'list-view list-group list-group-flush'
    ]
]); ?>

