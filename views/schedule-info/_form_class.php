<?php

use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\widgets\Select;
use app\models\Classroom;

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
<div class="form-group">
    <label class="control-label" for="#"><?= $model->getAttributeLabel('divisionName'); ?></label>
    <?= Html::tag('div', $model->divisionName, ['class' => 'form-control', 'style' => 'height: auto;']); ?>
</div>
<div class="form-group">
    <label class="control-label" for="#"><?= $model->getAttributeLabel('courseName'); ?></label>
    <?= Html::tag('div', $model->courseName, ['class' => 'form-control', 'style' => 'height: auto;']); ?>
</div>
<div class="form-group">
    <label class="control-label" for="#"><?= $model->getAttributeLabel('themeName'); ?></label>
    <?= Html::tag('div', $model->themeName, ['class' => 'form-control', 'style' => 'height: auto;']); ?>
</div>
<div class="form-group">
    <label class="control-label" for="#"><?= $model->getAttributeLabel('date'); ?></label>
    <?= Html::tag('div', $model->date, ['class' => 'form-control']); ?>
</div>
<div class="form-group">
    <label class="control-label" for="#"><?= $model->getAttributeLabel('startTime'); ?></label>
    <?= Html::tag('div', $model->startTime, ['class' => 'form-control']); ?>
</div>
<div class="form-group">
    <label class="control-label" for="#"><?= $model->getAttributeLabel('endTime'); ?></label>
    <?= Html::tag('div', $model->endTime, ['class' => 'form-control disabled']); ?>
</div>
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
<?= $form->field($model, 'id_course')->hiddenInput()->label(false); ?>
<?= $form->field($model, 'id_order')->hiddenInput()->label(false); ?>
<?php ActiveForm::end(); ?>
<?php Modal::end() ?>