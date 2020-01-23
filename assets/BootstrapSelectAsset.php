<?php

namespace app\assets;

use yii\web\AssetBundle;

class BootstrapSelectAsset extends AssetBundle
{
    public $sourcePath = '@app/node_modules/bootstrap-select/dist';
    public $js = [
        'js/bootstrap-select.js',
    ];
    public $css = [
        'css/bootstrap-select.css',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];

    public function init()
    {
        parent::init();

        $this->js[] = \Yii::$app->language == 'ru' ? 'js/i18n/defaults-ru_RU.js' : 'js/i18n/defaults-en_US.js';
    }
}
