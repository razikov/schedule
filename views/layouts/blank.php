<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use app\assets\AppAsset;
use app\assets\DragscrollAsset;

AppAsset::register($this);
DragscrollAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="dragscroll">
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
    <div class="container">
        <?= $content ?>
    </div>
</div>
<script>
setTimeout(function(){
    location.reload();
    console.log('refresh');
}, 60000);
</script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
