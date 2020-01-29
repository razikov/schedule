<?php
/**
 * @var $token string
 */
use yii\helpers\Html;
use yii\helpers\Url;

$url = Url::to(['site/change-password', 'token' => $token], true);
?>
Для смены пароля перейдите по ссылке <?= Html::a($url, $url) ?>
