<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\models\User;

AppAsset::register($this);
$formatter = Yii::$app->formatter;
$now = new DateTimeImmutable();
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'Расписание занятий ИРО',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => [
                [
                    'label' => \Yii::t('app', 'Расписание'),
                    'url' => '#',
                    'items' => [
                        [
                            'label' => \Yii::t('app', 'Список курсов'),
                            'url' => ['/schedule-info/index'],
                            'visible' => Yii::$app->user->can(User::SCHEDULE_COURSES_LIST),
                        ],
                        [
                            'label' => \Yii::t('app', 'Список занятий'),
                            'url' => ['/schedule-info/themes'],
                            'visible' => Yii::$app->user->can(User::SCHEDULE_THEMES_LIST),
                        ],
                        [
                            'label' => \Yii::t('app', 'Расписание'),
                            'url' => ['/schedule-info/presentation'],
                            'visible' => !Yii::$app->user->isGuest,
                        ],
                        [
                            'label' => \Yii::t('app', 'Карта аудиторий'),
                            'url' => ['/schedule-info/show'],
                            'visible' => Yii::$app->user->can(User::SCHEDULE_CLASSROOM_MAP),
                        ],
                    ],
                    'visible' => !Yii::$app->user->isGuest,
                ],
                [
                    'label' => \Yii::t('app', 'Администрирование'),
                    'url' => '#',
                    'items' => [
                        [
                            'label' => \Yii::t('app', 'Список пользователей'),
                            'url' => ['/user/index'],
                            'visible' => Yii::$app->user->can(User::USER_LIST),
                        ],
                    ],
                    'visible' => Yii::$app->user->can(User::ROLE_ADMIN),
                ],
                [
                    'label' => \Yii::t('app', 'Профиль'),
                    'url' => '#',
                    'items' => [
                        [
                            'label' => \Yii::t('app', 'Войти'),
                            'url' => ['/site/login'],
                            'visible' => Yii::$app->user->isGuest,
                        ],
                        [
                            'label' => \Yii::t('app', 'Выйти'),
                            'url' => ['/site/logout'],
                            'visible' => !Yii::$app->user->isGuest,
                        ],
                    ],
                ],
            ]
        ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <h3></h3>
        <?= $content ?>
    </div>
</div>

<!--<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Razikov А.А. <?= date('Y') ?></p>
        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>-->
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
