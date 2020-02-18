<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\ActiveForm;
use app\widgets\DatePicker;
use app\assets\JqueryDatePickerAsset;
use yii\helpers\Json;
use yii\web\View;

$this->title = 'Расписание занятий ГОАУ ЯО ИРО';
$formatter = Yii::$app->formatter;
JqueryDatePickerAsset::register($this);
$params = Json::encode([
    'format' => 'd.m.Y',
    'lang' => 'ru',
    'dayOfWeekStart' => 1,
    'timepicker' => false,
]);
$this->registerJs("$('#dateAt').datetimepicker({$params});", View::POS_READY);
?>
<?php if (!Yii::$app->user->isGuest): ?>
<div>
    <?php $form = ActiveForm::begin(['action' => [''], 'method' => 'get',]); ?>
    <section class="content-filters">
        <div class="css-xs-padding row">
            <div class="col-sm-4">
                <div class="form-group field-dateat">
                    <label class="control-label" for="dateAt">Дата</label>
                    <?= Html::input('text', 'dateAt', $dateAt, ['id' => 'dateAt', 'class' => "form-control datepicker"]); ?>
                    <div class="help-block"></div>
                </div>
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
    Сегодня <?= $formatter->asDate(time(), 'full') ?>
</div>

<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
    <?php foreach ($courses as $cid => $course) : ?>
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="<?= 'heading-' . $cid ?>">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#<?= 'collapse-' . $cid ?>" aria-expanded="true" aria-controls="<?= 'collapse-' . $cid ?>">
                        <strong><?= $course['courseName'] ?></strong> <?= $course['out'] ?><br>
                        <span style="font-size: 0.9em; font-style: italic">Подразделение: <?= $course['divisionName'] ?></span><br>
                    </a>
                </h4>
            </div>
            <div id="<?= 'collapse-' . $cid ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="<?= 'heading-' . $cid ?>">
                <?php foreach ($course['items'] as $tid => $theme) : ?>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-2">
                                Время: <strong><?= $theme->time ?> - <?= $theme->endTime ?></strong><br>
                                Аудитория: <strong><?= \yii\helpers\ArrayHelper::getValue(app\models\Classroom::getList(), $theme->classroom, '?') ?></strong><br>
                            </div>
                            <div class="col-md-10">
                                Тема: <strong><?= $theme->tname; ?></strong><br>
                                <?php if ($theme->subgroup != 0): ?>
                                Группа: <strong><?= $theme->subgroup; ?></strong><br>
                                <?php endif; ?>
                                Преподаватель: <strong><?= $theme->teacher; ?></strong><br>
                            </div>
                        </div>
<!--                        Тема: <strong><?= $theme->tname; ?></strong><br>
                        Время: <strong><?= $theme->time ?> - <?= $theme->endTime ?></strong><br>
                        Аудитория: <strong><?= $theme->classroom ?></strong><br>
                        Преподаватель: <strong><?= $theme->teacher; ?></strong><br>-->
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

