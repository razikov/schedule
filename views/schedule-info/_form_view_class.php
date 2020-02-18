<?php

use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<?php Modal::begin([
    'header' => '<h4 class="modal-title">Просмотр</h4>',
    'footer' => Html::button(Yii::t('app', 'Закрыть'), ['class' => 'btn btn-default', 'data-dismiss' => 'modal'])
]); ?>
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
<div class="form-group">
    <label class="control-label" for="#"><?= $model->getAttributeLabel('classroom'); ?></label>
    <?= Html::tag('div', $model->classroom, ['class' => 'form-control disabled']); ?>
</div>
<?php ActiveForm::end(); ?>
<?php Modal::end() ?>