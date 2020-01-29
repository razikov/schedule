<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\ActiveForm;
use app\widgets\DatePicker;

$this->title = 'Расписание занятий ГОАУ ЯО ИРО';
$formatter = Yii::$app->formatter;

?>
<div class="alert alert-info">
    Сегодня <?= $formatter->asDate(time(), 'full') ?>
</div>

<?= ListView::widget([
    'layout' => "{items}\n",
    'dataProvider' => $dataProvider,
    'itemView' => '_item_course',
    'options' => [
        'class' => 'list-view list-group list-group-flush'
    ]
]); ?>

