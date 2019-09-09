<?php
/**
 * Created by PhpStorm.
 * User: non
 * Date: 2019/9/9
 * Time: 10:33
 */

namespace backend\assets;


use yii\web\AssetBundle;

class JparticlesAssets extends AssetBundle
{
    public $sourcePath = '@node/jparticles/production';

    public $basePath = '@webroot/assets';

    public $css = [
    ];
    public $js = [
        'jparticles.js',
        'particle.js',
    ];
    public $depends = [
    ];

}