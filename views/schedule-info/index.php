<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\User;

$this->title = 'Список курсов';
$this->registerJs('
    bindModal(".js-themes-modal", {});
    bindModal(".js-course-classroom-modal", {
        afterShow: function (_modal) {
            courseClassroomList(_modal);
        }
    });
    function courseClassroomList() {
        bindModal(".js-form-course-classroom-modal", {
            beforeShow: function (_modal) {
                selectpicker(_modal);
                datepicker(_modal);
                timepicker(_modal);
            }
        });
    }
');
?>


<?= $this->render('_search', ['model' => $searchModel]); ?>

<?= GridView::widget([
    'tableOptions' => ['class' => 'table table-striped'],
    'dataProvider' => $dataProvider,
    'filterModel' => null,
    'columns' => [
        'ID',
        [
            'attribute' => 'IDDivision',
            'value' => function($item) {
                return $item->division->Name;
            }
        ],
        [
            'attribute' => 'Name',
            'value' => function($item) {
                return $item->Name;
            }
        ],
        [
            'format' => 'html',
            'header' => 'Занятия',
            'value' => function($item) {
                return Html::a(
                    count($item->courseThemes), 
                    Url::toRoute(['schedule-info/themes-modal', 'courseId' => $item->ID]),
                    ['class' => 'js-themes-modal']
                );
            }
        ],
        [
            'attribute' => 'StartDate',
            'value' => function($item) {
                return Yii::$app->formatter->asDate($item->StartDate);
            }
        ],
        [
            'attribute' => 'EndDate',
            'value' => function($item) {
                return Yii::$app->formatter->asDate($item->EndDate);
            }
        ],
    ],
]); ?>


