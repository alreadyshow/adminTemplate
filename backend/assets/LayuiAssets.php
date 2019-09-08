<?php


namespace backend\assets;


use yii\web\AssetBundle;

class LayuiAssets extends AssetBundle
{

    public $sourcePath = '@node';

    public $basePath = '@webroot/assets';

    public $css = [
        'layui-src/dist/css/layui.css'
    ];
    public $js = [
        'layui-src/dist/layui.all.js',
        'jparticles/production/jparticles.js',
        'jparticles/production/particle.js'
    ];
    public $depends = [
        'yii\web\YiiAsset'
    ];
}