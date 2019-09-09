<?php


namespace backend\assets;


use yii\web\AssetBundle;

class LayuiAsset extends AssetBundle
{

    public $sourcePath = '@node/layui-src/dist';

    public $basePath = '@webroot/assets';

    public $css = [
        'css/layui.css'
    ];
    public $js = [
        'layui.all.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'backend\assets\JparticlesAsset',
    ];
}