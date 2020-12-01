<?php

namespace wzzwx\yii2Inspinia\assets;

use yii\web\AssetBundle;

class InspiniaAsset extends AssetBundle
{
    public $sourcePath = __DIR__.'/src';
    public $js = [
        'js/site.js',
    ];
    public $css = [
        'css/kartik.css',
        'css/site.css',
        'css/box.css',
    ];
    public $depends = [
        AppAsset::class,
    ];
}
