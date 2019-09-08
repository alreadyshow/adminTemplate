<?php

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

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
<body class="layui-layout-body">
<?php $this->beginBody() ?>
<div class="layui-layout layui-layout-admin">
    <div class="layui-header">
        <ul class="layui-nav layui-layout-right">
            <li class="layui-nav-item">
                <a href="javascript:;">
                    <?= Html::img('/img/icon.png', ['class' => "layui-nav-img"]) ?>
                    <?= Yii::$app->user->identity->username ?>
                </a>
                <dl class="layui-nav-child">
                    <dd><?= Html::a('修改密码', '/admin/reset-password') ?></dd>
                </dl>
            </li>
            <li class="layui-nav-item">
                <?= Html::a('注销', '/site/logout', [
                    'data' => [
                        'method' => 'post'
                    ]
                ]) ?>
            </li>
        </ul>
    </div>

    <div class="layui-side layui-bg-black">
        <div class="layui-side-scroll">
            <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
            <ul class="layui-nav layui-nav-tree" lay-filter="test">
                <?php foreach ([] as $item): ?>
                    <li class="layui-nav-item <?= $item['active'] ? 'layui-nav-itemed' : '' ?>">
                        <a class="" href="javascript:;"><?= $item['label'] ?></a>
                        <dl class="layui-nav-child">
                            <?php foreach ($item['items'] as $child): ?>
                                <dd class="<?= $child['active'] ? 'layui-this' : '' ?>"><a
                                            href="<?= Url::toRoute($child['url']) ?>"><?= $child['label'] ?></a></dd>
                            <?php endforeach; ?>
                        </dl>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <div class="layui-body">
        <!-- 内容主体区域 -->
        <div class="layui-row">
            <div class="layui-col-xs12">
                <div class="layui-card admin-breadcrumb">
                    <?= Breadcrumbs::widget([
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                        'options' => ['class' => 'layui-breadcrumb'],
                        'tag' => 'span',
                        'homeLink' => [
                            'label' => '首页',                  // required
                            'url' => '/',                      // optional, will be processed by Url::to()
                            'template' => "{link}\n", // optional, if not set $this->itemTemplate will be used
                        ],
                        'itemTemplate' => "{link}\n",
                        'activeItemTemplate' => "<a><cite>{link}</cite></a>\n"
                    ]) ?>
                </div>
            </div>
        </div>
        <div class="layui-row admin-content">
            <div class="layui-col-xs12">
                <?= $content ?>
            </div>
        </div>
    </div>
    <div class="layui-footer">
        <!-- 底部固定区域 -->
        &copy; Admin Template <?= date('Y') ?> - <?= Yii::powered() ?>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
