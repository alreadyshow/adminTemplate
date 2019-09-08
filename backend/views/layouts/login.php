<?php

use backend\assets\AppAsset;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="layui-layout-body" style="background: #f2f2f2">
<?php $this->beginBody() ?>
<div id="demo" style="width: 100%;height: 100%;position: absolute;overflow: hidden;"></div>
<div class="layui-layout layui-layout layui-layout-admin-empty">
    <div style="position:absolute;left: 40%;">
        <?= $content ?>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
