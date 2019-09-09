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

    public $sourcePath = '@backend/widgets/assets/layui-formselects/dist';

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