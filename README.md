<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">使用 Yii2 高级模板搭建</h1>
    <br>
</p>

目录结构
-------------------

```
common
    config/              contains shared configurations
    mail/                contains view files for e-mails
    models/              contains model classes used in both backend and frontend
    tests/               contains tests for common classes    
console
    config/              contains console configurations
    controllers/         contains console controllers (commands)
    migrations/          contains database migrations
    models/              contains console-specific model classes
    runtime/             contains files generated during runtime
backend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains backend configurations
    controllers/         contains Web controller classes
    models/              contains backend-specific model classes
    runtime/             contains files generated during runtime
    tests/               contains tests for backend application    
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
frontend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains frontend configurations
    controllers/         contains Web controller classes
    models/              contains frontend-specific model classes
    runtime/             contains files generated during runtime
    tests/               contains tests for frontend application
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
    widgets/             contains frontend widgets
vendor/                  contains dependent 3rd-party packages
environments/            contains environment-based overrides
```

基本使用
-------------------
所有组件均在 backend/widgets 目录下

[GridView]
```php
<?php

use backend\widgets\layuiGridView\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\TSBankAgentCodeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('norm', 'Bank Agent Codes');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tsbank-agent-code-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('norm', 'Create'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            [
                'attribute' => 'id',
                'options' => [
                    'width' => '80',
                    'unresize' => true,
                    'fixed' => true,
                    'value' => new \yii\web\JsExpression("function (d) {
                        return (d.id > 3) ? 333 : d.id ;
                    }")
                ],
            ],
            'bank_code',
            'bank_name',
        ],
    ]); ?>

</div>

```

[ActiveForm]
```php
<?php

use backend\widgets\layuiForm\ActiveForm;
use common\helpers\HtmlHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TSBankAgentCode */

$this->title = Yii::t('norm', 'Create Bank Agent Code');
$this->params['breadcrumbs'][] = ['label' => Yii::t('norm', 'Bank Agent Codes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="tsbank-agent-code-create">

        <h1><?= Html::encode($this->title) ?></h1>

        <?php $form = ActiveForm::begin([
            'verify' => [
                'title' => "form.verify({
                                title: function (value) {
                                  if (value.length < 5) {
                                    return '标题也太短了吧';
                                  }
                                }
                              });"
                ]
            ]); ?>

        <?= $form->field($model, 'bank_code')->checkboxList([0 => 'nan', 1 => 'nv', 2 => 'sss']) ?>

        <?= $form->field($model, 'bank_code')->switchInput() ?>
        <?= $form->field($model, 'bank_code')->radioList([0 => 'nan', 1 => 'nv', 2 => 'sss']) ?>

        <?= $form->field($model, 'bank_name')->dateInput(['id' => 'date', 'placeholder' => 'yyyy-MM-dd', 'autocomplete' => 'off'], [
            'range' => '~',
            'theme' => 'molv',
        ]) ?>

        <div class="layui-form-item">
            <?= HtmlHelper::submitButton('Save', ['class' => 'layui-btn', 'lay-filter' => '*']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
<?php

$js = <<<JS
//无需再执行layui.use()方法加载模块，直接使用即可
  var form = layui.form
  ,layer = layui.layer;
  
  form.verify({
    title: function (value) {
        console.log(value);
      if (value.length < 5) {
        return '标题也太短了吧';
      }
    }
    , pass: [/(.+){6,12}$/, '密码必须6到12位']
    , money: [
      /^\d+\.\b\d{2}\b$/
      , '金额必须为小数保留两位'
    ]
  });
JS;

$this->registerJs($js);

```