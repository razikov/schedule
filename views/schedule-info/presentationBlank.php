<?php

$this->title = 'Расписание занятий ГОАУ ЯО ИРО';
$formatter = Yii::$app->formatter;
?>
<!--<div class="alert alert-warning">
    Система работает в тестовом режиме
</div>-->
<div class="alert alert-info">
    Сегодня <?= $formatter->asDate(time(), 'full') ?>
</div>

<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
    <?php foreach ($courses as $cid => $course) : ?>
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="<?= 'heading-' . $cid ?>">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#<?= 'collapse-' . $cid ?>" aria-expanded="true" aria-controls="<?= 'collapse-' . $cid ?>">
                        <div class="media">
                            <div class="media-left">
                                <span style="font-size: 2em;" class="glyphicon glyphicon-hand-up" aria-hidden="true"></span>
                            </div>
                            <div class="media-body">
                                <strong><?= $course['courseName'] ?></strong> <?= $course['out'] ?><br>
                                <span style="font-size: 0.9em; font-style: italic"><?= $course['divisionName'] ?></span><br>
                            </div>
                        </div>
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
