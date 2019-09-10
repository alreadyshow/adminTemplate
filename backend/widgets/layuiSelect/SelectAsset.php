<?php


namespace backend\widgets\layuiForm;


use yii\web\AssetBundle;

class SelectAsset extends AssetBundle
{
    public $sourcePath = __DIR__ . '/assets/layui-formSelects-master/dist';

    public $basePath = '@webroot/assets';

    public $css = [
        'formSelects-v4.css',
    ];
    public $js = [
        'formSelects-v4.min.js',
    ];
    public $depends = [
        'backend\assets\AppAsset'
    ];

}