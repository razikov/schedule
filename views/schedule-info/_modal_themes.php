<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\bootstrap\Modal;

$this->title = 'Tests';
?>

<?php Modal::begin([
    'size' => Modal::SIZE_LARGE,
    'header' => '<h4 class="modal-title">'.$courseName.'</h4>',
    'footer' => Html::button(Yii::t('app', 'Закрыть'), ['class' => 'btn btn-default', 'data-dismiss' => 'modal'])
]); ?>

<?= GridView::widget([
    'tableOptions' => ['class' => 'table table-striped'],
    'dataProvider' => $dataProvider,
    'filterModel' => null,
    'columns' => [
        [
            'class' => 'yii\grid\SerialColumn',
        ],
        [
            'attribute' => 'IDTheme',
            'value' => function($item) {
                return $item->theme->Name;
            }
        ],
        [
            'attribute' => 'IDTeacher',
            'value' => function($item) {
                return $item->teacher->fullName;
            }
        ],
        [
            'attribute' => 'Date1',
            'value' => function($item) {
                return Yii::$app->formatter->asDate($item->Date1);
            }
        ],
    ],
]); ?>

<?php Modal::end() ?>


