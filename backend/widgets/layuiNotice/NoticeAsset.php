<?php


namespace backend\widgets\layuiNotice;


use yii\web\AssetBundle;

class NoticeAsset extends AssetBundle
{
    public $sourcePath = __DIR__ . '/assets/layuinotice-master/dist';

    public $basePath = '@webroot/assets';

    public $css = [
        'notice.css',
    ];

    public $js = [
        'notice.js',
    ];

    public $depends = [
    ];

}