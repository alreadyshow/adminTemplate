<?php
/**
 * Created by PhpStorm.
 * User: non
 * Date: 2019/9/9
 * Time: 15:27
 */

namespace backend\assets;


use yii\web\AssetBundle;

class NoticeAsset extends AssetBundle
{

    public $sourcePath = '@backend/widgets/assets';

    public $basePath = '@webroot/assets';

    public $css = [
        'layuinotice-master/dist/notice.css',
    ];

    public $js = [
        'layuinotice-master/dist/notice.js',
    ];

    public $depends = [
    ];

}