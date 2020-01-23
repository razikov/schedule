<?php

use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\widgets\DatePicker;
use app\widgets\TimePicker;

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
        Html::button(Yii::t('app', 'Закрыть'), ['class' => 'btn btn-sm btn-default', 'data-dismiss' => 'modal']).
        Html::button(
            $model->isNewRecord ? Yii::t('app', 'Добавить') : Yii::t('app', 'Сохранить'),
            ['class' => 'btn btn-primary js-submit']
        )
]); ?>
<?= Html::errorSummary($model) ?>
<?php $form = ActiveForm::begin(['options' => ['autocomplete' => 'off']]); ?>
<?= $form->field($model, 'teacher')->textInput(['class' => 'form-control']); ?>
<?= $form->field($model, 'name')->textInput(['class' => 'form-control']); ?>
<?= $form->field($model, 'division')->textInput(['class' => 'form-control']); ?>
<?= $form->field($model, 'eventDate')->widget(
        DatePicker::class, [
            'format' => 'Y.m.d',
            'options' => [
                'class' => 'form-control',
            ],
            'params' => [
                'weeks' => true,
            ],
        ]);
?>
<?= $form->field($model, 'startTime')->widget(TimePicker::class, []); ?>
<?= $form->field($model, 'endTime')->widget(TimePicker::class, []); ?>
<?= $form->field($model, 'class')->textInput(['class' => 'form-control']); ?>
<?php ActiveForm::end(); ?>
<?php Modal::end() ?>