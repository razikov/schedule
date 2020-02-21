<?php

namespace app\assets;

use yii\web\AssetBundle;

class DragscrollAsset extends AssetBundle
{
    public $sourcePath = '@app/node_modules/dragscroll';
    public $js = [
        'dragscroll.js',
    ];
    public $css = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
