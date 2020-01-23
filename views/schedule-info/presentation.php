<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\ActiveForm;
use app\widgets\DatePicker;

$this->title = 'Tests';
$formatter = Yii::$app->formatter;
$now = date("d.m.Y");
?>
<?php if (!Yii::$app->user->isGuest): ?>
<div>
    <?php $form = ActiveForm::begin(['action' => [''], 'method' => 'get',]); ?>
    <section class="content-filters">
        <div class="css-xs-padding row">
            <div class="col-sm-4">
                <?= $form->field($searchModel, 'dateAt')->widget(
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
<?php endif; ?>
<div class="alert alert-info">
    Сегодня <?= $formatter->asDate($now, 'full') ?>
</div>

<?= ListView::widget([
    'layout' => "{items}\n",
    'dataProvider' => $dataProvider,
    'itemView' => '_item',
    'options' => [
        'class' => 'list-view list-group list-group-flush'
    ]
]); ?>

