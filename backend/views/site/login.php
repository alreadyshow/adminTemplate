<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('norm', 'Login');
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="site-login">


        <div class="layui-card">
            <div class="layui-card-header">
                <div class="admin-login-box">
                    <h1><?= Html::encode($this->title) ?></h1>
                </div>
            </div>
            <div class="layui-card-body" style="margin-top: 20px;">
                <?php $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'class' => 'layui-form',
                    'fieldConfig' => [
                        'template' => "<div class=\"layui-form-item\">{input}</div>\n<blockquote>{error}</blockquote>",
                    ],
                ]); ?>
                <label class="layui-icon layui-icon-username admin-icon-username" for="loginform-username"></label>
                <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'class' => 'layui-input admin-login-input', 'placeholder' => '用户名：test']) ?>
                <label class="layui-icon layui-icon-password admin-icon-password" for="loginform-password"></label>
                <?= $form->field($model, 'password')->passwordInput(['class' => 'layui-input admin-password-input', 'placeholder' => '密码：123456']) ?>

                <?= $form->field($model, 'rememberMe')->checkbox([
                    'lay-skin' => 'primary',
                ])->label(Yii::t('norm', "rememberMe")) ?>

                <div class="form-group">
                    <?= Html::submitButton(Yii::t('norm', 'Login'), ['class' => 'layui-btn layui-btn-fluid', 'name' => 'login-button']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
<?php

$js = <<<JS
    // 使用 new JParticles.特效名 创建特效
    var effect = new JParticles.particle('#demo', {
        // 两粒子圆心点之间的直线距离为 90
        proximity: 110,
        // 定位点半径 100 以内（包含）的所有粒子，圆心点之间小于等于 proximity 值，则连线
        range: 0,
        parallax: true,
        lineShape: 'cube',
        parallaxLayer: [1, 3, 10, 18],
        lineWidth: 0,
        num: 0.3,
    });
JS;

$this->registerJs($js);