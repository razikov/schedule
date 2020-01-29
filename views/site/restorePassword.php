<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = Yii::t('app', 'Восстановление пароля / Смена пароля');
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-reset-password">
    <div class="clearfix">
        <div class="col-sm-6 col-sm-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title text-center"><?= Html::encode($this->title) ?></div>
                </div>
                <div class="panel-body">
                    <?= \app\widgets\Alert::widget() ?>
                    <div class="form">

                        <?php $form = ActiveForm::begin([
                            'id' => 'reset-form',
                            'options' => ['class' => ''],
                            'fieldConfig' => [
                                'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-6\">{error}</div>",
                                'labelOptions' => ['class' => 'col-lg-4 control-label'],
                            ],
                        ]); ?>

                        <?= $form->field($model, 'email', [
                            'template' => '<div class="input-group input-group-sm"><span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>{input}</div>{error}'
                        ])->textInput([
                            'class' => 'form-control',
                            'placeholder' => Yii::t('app', 'Введите E-mail'),
                        ]) ?>

                        <?= $form->field($model, 'verifyCode')->widget(
                            \yii\captcha\Captcha::class,
                            ['class' => 'form-control']
                        ) ?>

                        <?= Html::submitButton(
                            Yii::t('app', 'Восстановить'),
                            ['class' => 'btn btn-default btn-sm pull-right', 'name' => 'reset-password-button']) ?>

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

