<?php

use app\models\Department;
use app\models\User;
use app\models\UserForm;
use app\modules\lms\models\RequestType;
use app\widgets\DatePicker;
use app\widgets\Select;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\Html;

/**
 * @var $this yii\web\View
 * @var $model UserForm
 * @var $form yii\widgets\ActiveForm
 * @var $header string
 * @var $roles string[]
 * @var $positions array
 */

?>
<?php Modal::begin(
    [
        'header' => '<h4 class="modal-title">'.($model->isNewRecord ? Yii::t('app', 'Новый пользователь') : Yii::t(
                'app',
                'Редактирование пользователя'
            )).'</h4>',
        'footer' => Html::button(
                Yii::t('app', 'Закрыть'),
                ['class' => 'btn btn-default', 'data-dismiss' => 'modal']
            ).
            Html::button(
                $model->isNewRecord ? Yii::t('app', 'Добавить') : Yii::t('app', 'Сохранить'),
                ['class' => 'btn btn-primary js-submit']
            ).''
//            Html::button(
//                $model->isNewRecord ? Yii::t('app', 'Добавить и отправить на e-mail') : Yii::t(
//                    'app',
//                    'Сохранить и отправить на e-mail'
//                ),
//                ['class' => 'btn btn-primary js-submit-and-send-email'.($model->isNewRecord ? '' :' disabled')])
    ]
); ?>
<?php $form = ActiveForm::begin(['options' => ['autocomplete' => 'off']]); ?>
    <input type="text" style="display:none">
    <input type="password" style="display:none">
    <?= $form->field($model, 'sendEmail', ['template' => '{input}'])->hiddenInput(['id' => 'js-send-email']) ?>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'first_name')->textInput(['class' => 'form-control']); ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'middle_name')->textInput(['class' => 'form-control']); ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'last_name')->textInput(['class' => 'form-control']); ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'email')->textInput(['class' => 'form-control']); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'role')->widget(
                    Select::class, [
                        'options' => [
                            'class' => 'form-control js-role',
                            'prompt' => Yii::t('app', 'Не выбрано'),
                            'data-style' => 'btn-default',
                        ],
                        'items' => User::getRoleList(),
                    ])
            ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'status')->widget(
                    Select::class, [
                        'options' => [
                            'class' => 'form-control',
                            'data-style' => 'btn-default',
                        ],
                        'items' => User::getStatusList(),
                    ])
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'password')->passwordInput(['class' => 'form-control password']) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'passwordVerify')->passwordInput(['class' => 'form-control password']) ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>
<?php Modal::end() ?>