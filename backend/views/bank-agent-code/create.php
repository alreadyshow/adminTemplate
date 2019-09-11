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
