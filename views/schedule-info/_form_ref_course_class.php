<?php

use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\widgets\DatePicker;
use app\widgets\TimePicker;
use app\widgets\Select;
use app\models\Classroom;

/**
 * @var $this yii\web\View
 * @var $model app\models\Holding
 * @var $form yii\widgets\ActiveForm
 */
?>

<?php Modal::begin([
    'header' => '<h4 class="modal-title">'.($model->isNewRecord ? Yii::t('app', 'Создание') : Yii::t(
            'app',
            'Редактирование'
        )).'</h4>',
    'footer' =>
        Html::button(Yii::t('app', 'Закрыть'), ['class' => 'btn btn-default', 'data-dismiss' => 'modal']).
        Html::button(
            $model->isNewRecord ? Yii::t('app', 'Добавить') : Yii::t('app', 'Сохранить'),
            ['class' => 'btn btn-primary js-submit']
        )
]); ?>
<?= Html::errorSummary($model) ?>
<?php $form = ActiveForm::begin(['options' => ['autocomplete' => 'off']]); ?>
<h4>
    <?= $model->course->Name ?>
</h4>
<?= $form->field($model, 'dateAt')->widget(
        DatePicker::class, [
            'format' => 'Y.m.d',
            'options' => [
                'class' => 'form-control',
            ],
            'params' => [
                'weeks' => true,
            ],
        ])
?>
<?= $form->field($model, 'classroom')->widget(
        Select::class, [
            'options' => [
                'class' => 'form-control',
                'data-style' => 'btn-default',
                'data-live-search' => 1,
                'prompt' => Yii::t('app', 'Ничего не выбрано'),
            ],
            'items' => Classroom::getList()
        ])
?>
<?= $form->field($model, 'startTimeAt')->widget(
        TimePicker::class, [
//            'format' => 'H:i',
            'options' => [
                'class' => 'form-control',
            ],
            'params' => [
                'minTime' => '08:00',
                'maxTime' => '20:00',
            ],
        ])
?>
<?= $form->field($model, 'id_course')->hiddenInput()->label(false); ?>
<?php ActiveForm::end(); ?>
<?php Modal::end() ?>