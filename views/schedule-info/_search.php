<?php

use app\models\InfoDivision;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\widgets\DatePicker;
use app\widgets\Select;
//$this->registerJs('$("body").on("click", ".js-filter", function () { $("#js-search").toggle(); });');
?>
<?= ''//Html::a(Yii::t('app', 'Фильтр'), '#', ['class' => 'btn btn-success js-filter']) ?>

<!--<div id="js-search" style="display: none;">-->
<div>
    <?php $form = ActiveForm::begin(['action' => [''], 'method' => 'get',]); ?>
    <section class="content-filters">
        <div class="css-xs-padding row">
            <div class="col-sm-4">
                <?= $form->field($model, 'IDDivision')->widget(
                    Select::class, [
                        'options' => [
                            'class' => 'form-control',
                            'data-style' => 'btn-default',
                            'data-live-search' => 1,
                            'prompt' => Yii::t('app', 'Ничего не выбрано'),
                        ],
                        'items' => InfoDivision::getList()
                    ])
                ?>
            </div>
            <div class="col-sm-4">
                <?= $form->field($model, 'Name')->textInput(['class' => 'form-control']); ?>
            </div>
            <div class="col-sm-4">
                <?= $form->field($model, 'dateAt')->widget(
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