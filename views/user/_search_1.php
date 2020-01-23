<?php

use app\models\User;
use app\widgets\Select;
use yii\bootstrap\Dropdown;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $this yii\web\View
 * @var $model app\models\UserSearch
 * @var $form yii\widgets\ActiveForm
 */
$this->registerJs('$("body").on("click", ".js-filter", function () { $(".js-user-search").toggle(); });');
?>
<?= Html::a(Yii::t('app', 'Фильтр'), '#', ['class' => 'btn btn-success js-filter']) ?>

<div class="css-search js-user-search" style="display: none;">
    <?php $form = ActiveForm::begin(['action' => ['index'], 'method' => 'get',]); ?>
    <section class="content-filters">
        <div class="css-xs-padding row">
            <div class="col-sm-3">
                <?= $form->field($model, 'id')->textInput(['class' => 'form-control']); ?>
            </div>
            <div class="col-sm-3">
                <?= $form->field($model, 'first_name')->textInput(['class' => 'form-control']); ?>
            </div>
            <div class="col-sm-3">
                <?= $form->field($model, 'middle_name')->textInput(['class' => 'form-control']); ?>
            </div>
            <div class="col-sm-3">
                <?= $form->field($model, 'last_name')->textInput(['class' => 'form-control']); ?>
            </div>
            <div class="col-sm-3">
                <?= $form->field($model, 'roles')->widget(
                    Select::class,
                    [
                        'options' => [
                            'class' => 'form-control',
                            'data-style' => 'btn-default',
                            'multiple' => 'multiple',
                        ],
                        'items' => User::getRoleList(),
                    ]
                );
                ?>
            </div>
            <div class="col-sm-3">
                <?= $form->field($model, 'email')->textInput(['class' => 'form-control']); ?>
            </div>
            <div class="col-sm-3">
                <?= $form->field($model, 'status')->widget(
                    Select::class,
                    [
                        'options' => [
                            'class' => 'form-control',
                            'data-style' => 'btn-default',
                        ],
                        'items' => User::getStatusList(),
                    ]
                ); ?>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="" class="control-label">&nbsp;</label>
                    <?= Html::submitButton(Yii::t('app', 'Найти'), ['class' => 'btn btn-primary']) ?>
                    <?= Html::a(Yii::t('app', 'Сброс'), ['index'], ['class' => 'btn btn-default']) ?>
                </div>
            </div>
        </div>
    </section>
    <?php ActiveForm::end(); ?>
</div>