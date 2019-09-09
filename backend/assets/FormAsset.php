<?php
/**
 * Created by PhpStorm.
 * User: non
 * Date: 2019/9/9
 * Time: 10:38
 */

namespace backend\assets;


use yii\web\AssetBundle;

class FormAsset extends AssetBundle
{

    public $sourcePath = '@backend/widgets/assets';

    public $basePath = '@webroot/assets';

    public $css = [
        'layui-formselects/dist/formSelects-v4.css',
        'form.css',
    ];
    public $js = [
        'layui-formselects/dist/formSelects-v4.min.js',
        'form.js',
    ];
    public $depends = [
        'backend\assets\AppAsset'
    ];

}