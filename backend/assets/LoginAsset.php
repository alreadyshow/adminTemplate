<?php
/**
 * Created by PhpStorm.
 * User: non
 * Date: 2019/9/9
 * Time: 17:04
 */

namespace backend\assets;


use yii\web\AssetBundle;

class LoginAsset extends AssetBundle
{

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '/css/site.css',
    ];
    public $js = [
        '/js/app.js',
    ];
    public $depends = [
        'backend\assets\LayuiAsset',
        'backend\assets\JparticlesAsset',
    ];
}