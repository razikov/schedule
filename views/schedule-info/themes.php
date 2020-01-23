<?php

use app\models\InfoCourse;
use app\models\InfoDivision;
use app\models\InfoTeacher;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\widgets\Select;
use app\widgets\DatePicker;
use app\models\User;

$this->title = 'Tests';
$this->registerJs('
    bindModal(".js-show-modal", {
        beforeShow: function (_modal) {
            selectpicker(_modal);
        }
    });
');
?>

<div>
    <?php $form = ActiveForm::begin(['action' => [''], 'method' => 'get',]); ?>
    <section class="content-filters">
        <div class="css-xs-padding row">
            <div class="col-sm-4">
                <?= $form->field($searchModel, 'idCourseDivision')->widget(
                    Select::class,
                    [
                    'options' => [
                        'class' => 'form-control',
                        'data-style' => 'btn-default',
                        'data-live-search' => 1,
                        'prompt' => Yii::t('app', 'Ничего не выбрано'),
                    ],
                    'items' => InfoDivision::getList()
                ]) ?>
            </div>
            <div class="col-sm-4">
                <?= $form->field($searchModel, 'courseName')->textInput(['class' => 'form-control']); ?>
            </div>
            <div class="col-sm-4">
                <?= $form->field($searchModel, 'IDTeacher')->widget(
                    Select::class,
                    [
                    'options' => [
                        'class' => 'form-control',
                        'data-style' => 'btn-default',
                        'data-live-search' => 1,
                        'prompt' => Yii::t('app', 'Ничего не выбрано'),
                    ],
                    'items' => InfoTeacher::getList()
                ]) ?>
            </div>
            <div class="col-sm-4">
                <?= $form->field($searchModel, 'themeName')->textInput(['class' => 'form-control']); ?>
            </div>
            <div class="col-sm-4">
                <?= $form->field($searchModel, 'dateAt')->widget(
                    DatePicker::class, [
                        'format' => 'd.m.Y',
                        'options' => [
                            'class' => 'form-control',
                        ],
                        'params' => [
                            'weeks' => true,
                        ],
                    ]);
                ?>
            </div>
            <div class="col-sm-3">
                <div class="form-group"> 
                    <label for="" class="control-label">&nbsp;</label>
                    <div class="">
                        <?= Html::submitButton(Yii::t('app', 'Найти'), ['class' => 'btn btn-primary']) ?>
                        <?= Html::a(Yii::t('app', 'Сброс'), [''], ['class' => 'btn btn-default']) ?>                        
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php ActiveForm::end(); ?>
</div>

<?= GridView::widget([
    'tableOptions' => ['class' => 'table table-striped'],
    'dataProvider' => $dataProvider,
    'filterModel' => null,
    'columns' => [
        [
            'header' => '#',
            'value' => function($item) {
                return "$item->IDCourse-$item->Order1";
            }
        ],
        [
            'attribute' => 'IDCourse',
            'value' => function($item) {
                return $item->course->Name;
            }
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
        [
            'header' => 'Время',
            'value' => function($item) {
                return sprintf("%s - %s", $item->time, $item->endTime);
            }
        ],
        [
            'header' => 'Ауд.',
            'value' => function($item) {
                return $item->classroom ? $item->classroom->classroom : "-";
            }
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{create-class}{update-class}{delete-class}',
            'buttons' => [
                'create-class' => function ($url, $model) {
                    if ($model->classroom) {
                        return false;
                    }
                    return Html::a(
                            '<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>',
                            \yii\helpers\Url::toRoute(['schedule-info/create-class', 'IDCourse' => $model->IDCourse, 'Order1' => $model->Order1]),
                            ['class' => 'js-show-modal', 'title' => Yii::t('app', 'Создать')]
                        );
                },
                'update-class' => function ($url, $model) {
                    if (!$model->classroom) {
                        return false;
                    }
                    return Html::a(
                            '<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>',
                            \yii\helpers\Url::toRoute(['schedule-info/update-class', 'id' => $model->classroom->id]),
                            ['class' => 'js-show-modal', 'title' => Yii::t('app', 'Редактировать')]
                        );
                },
                'delete-class' => function ($url, $model) {
                    if (!$model->classroom) {
                        return false;
                    }
                    return Html::a(
                            '<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>',
                            \yii\helpers\Url::toRoute(['schedule-info/delete-class', 'id' => $model->classroom->id, 'returnUrl' => \yii\helpers\Url::current(),]),
                            [
                                'title' => Yii::t('app', 'Удалить'),
                                'data-confirm' => Yii::t('yii', 'Вы действительно хотите удалить?'),
                                'data-method' => 'post',
                            ]
                        );
                },
            ],
            'visibleButtons' => [
                'create-class' => Yii::$app->user->can(User::SCHEDULE_RESERVATION_CREATE),
                'update-class' => Yii::$app->user->can(User::SCHEDULE_RESERVATION_UPDATE),
                'delete-class' => Yii::$app->user->can(User::SCHEDULE_RESERVATION_DELETE),
            ],
        ],
    ],
]); ?>


