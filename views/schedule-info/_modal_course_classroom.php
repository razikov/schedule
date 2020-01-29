<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use app\models\User;

$this->title = 'Tests';
?>

<?php Modal::begin([
    'size' => Modal::SIZE_LARGE,
    'header' => '<h4 class="modal-title">'.$searchModel->course->Name.'</h4>',
    'footer' => 
        Html::button(Yii::t('app', 'Закрыть'), ['class' => 'btn btn-default', 'data-dismiss' => 'modal'])
]); ?>

<?php if (Yii::$app->user->can(User::SCHEDULE_RESERVATION_CREATE)) {
    echo Html::a(
            'Добавить',
            \yii\helpers\Url::toRoute(['schedule-info/create-ref-course-class', 'idCourse' => $searchModel->course->ID]),
            ['class' => 'btn btn-primary js-form-course-classroom-modal', 'title' => Yii::t('app', 'Создать')]
        );
}
?>


<?= GridView::widget([
    'tableOptions' => ['class' => 'table table-striped'],
    'dataProvider' => $dataProvider,
    'filterModel' => null,
    'columns' => [
        [
            'class' => 'yii\grid\SerialColumn',
        ],
        'classroom',
        [
            'attribute' => 'date',
            'value' => function($item) {
                return Yii::$app->formatter->asDate($item->date);
            }
        ],
        'startTimeAt',
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update-ref-course-class} {delete-ref-course-class}',
            'buttons' => [
                'update-ref-course-class' => function ($url, $model) {
                    if (!$model->classroom) {
                        return false;
                    }
                    return Html::a(
                            '<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>',
                            \yii\helpers\Url::toRoute(['schedule-info/update-ref-course-class', 'id' => $model->id]),
                            ['class' => 'js-form-course-classroom-modal', 'title' => Yii::t('app', 'Редактировать')]
                        );
                },
                'delete-ref-course-class' => function ($url, $model) {
                    if (!$model->classroom) {
                        return false;
                    }
                    return Html::a(
                            '<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>',
                            \yii\helpers\Url::toRoute(['schedule-info/delete-ref-course-class', 'id' => $model->id, 'returnUrl' => \yii\helpers\Url::current(),]),
                            [
                                'title' => Yii::t('app', 'Удалить'),
                                'data-confirm' => Yii::t('yii', 'Вы действительно хотите удалить?'),
                                'data-method' => 'post',
                                'class' => 'js-form-course-classroom-modal',
                            ]
                        );
                },
            ],
            'visibleButtons' => [
                'update-ref-course-class' => Yii::$app->user->can(User::SCHEDULE_RESERVATION_UPDATE),
                'delete-ref-course-class' => Yii::$app->user->can(User::SCHEDULE_RESERVATION_DELETE),
            ],
        ],
    ],
]); ?>

<?php Modal::end() ?>


