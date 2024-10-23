<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/style.css',
        'css/bootstrap.min.css',
        'css/bootstrap-grid.min.css',
        'css/bootstrap-reboot.min.css',
    ];
    public $js = [
        'js/bootstrap.bundle.min.js',
        'js/bootstrap.min.js',
        'js/popper.min.js',
        'js/main.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
    ];
}
