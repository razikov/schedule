<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = Yii::t('app', 'Смена пароля');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-reset-password">
    <h2 class="page-title"><?= Html::encode($this->title) ?></h2>

    <div class="clearfix">
        <div class="col-sm-6 col-sm-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title text-center"><?= Yii::t('app', 'Смена пароля'); ?></div>
                </div>
                <div class="panel-body">
                    <?= \app\widgets\Alert::widget() ?>
                    <div class="form">

                        <?php $form = ActiveForm::begin([
                            'id' => 'change-password-form',
                            'options' => ['class' => ''],
                        ]); ?>

                        <input type="password" style="display:none">
                        <?= $form->field($model, 'password')->passwordInput([
                            'class' => 'form-control ps-input',
                            'placeholder' => Yii::t('app', 'Введите новый пароль'),
                        ]) ?>

                        <?= $form->field($model, 'passwordVerify')->passwordInput([
                            'class' => 'form-control ps-input',
                            'placeholder' => Yii::t('app', 'Повторите ввод нового пароля'),
                        ]) ?>

                        <?= Html::submitButton(
                            Yii::t('app', 'Сохранить'),
                            ['class' => 'btn btn-default btn-sm pull-right', 'name' => 'change-password-button']) ?>

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

