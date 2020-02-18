<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = Yii::t('app', 'Авторизация');
?>
<div class="site-login">
    <div class="clearfix">
    <div class="col-sm-6 col-sm-offset-3">
        <div class="panel panel-default" >
            <div class="panel-heading">
                <div class="panel-title text-center"><?= Yii::t('app', 'Вход в систему') ?></div>
            </div>     
            <div class="panel-body" >
                <div class="form">
                    <?php $form = ActiveForm::begin([
                        'id' => 'login-form',
                        'options' => ['class' => ''],
                        'fieldConfig' => [
                            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                            'labelOptions' => ['class' => 'col-lg-1 control-label'],
                        ],
                    ]); ?>

                    <?= $form->field($model, 'email', [
                        'template' => '<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>{input}</div>{error}'
                    ])->textInput(['class'=>'form-control']) ?>

                    <?= $form->field($model, 'password', [
                        'template' => '<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>{input}</div>{error}'
                    ])->passwordInput(['class'=>'form-control']) ?>

                    <?= '' /*Yii::t('app', 'Для восстановления пароля перейдите') ?> <?= Html::a(
                        Yii::t('app', 'по ссылке'),
                        ['site/restore-password']
                    )*/ ?>

                    <?= Html::submitButton(
                        Yii::t('app', 'Войти'),
                        ['class' => 'btn btn-default pull-right', 'name' => 'login-button']
                    ) ?>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

