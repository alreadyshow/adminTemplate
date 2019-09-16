<?php

use backend\widgets\layuiGridView\GridView;
use yii\helpers\Html;

use yii\grid\GridView as Grid;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\TSBankAgentCodeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('norm', 'Bank Agent Codes');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tsbank-agent-code-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
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
            [
                'class' => 'backend\widgets\layuiGridView\ActionColumn',
                'title' => '操作',
                'template' => '{edit} {delete}',
                'buttons' => [
                    'edit' => [
                        'options' => [],
                        'content' => Html::a("编辑",'#',[
                            'class' => 'layui-btn layui-btn-xs',
                            'lay-event' => 'edit',
                        ]),
                        'script' => new \yii\web\JsExpression("layer.prompt({
                            formType: 2
                            ,value: data.bank_code
                          }, function(value, index){
                            $.post('http://127.0.0.1:10088/examples/test.php', {\"data\": value}, function (data, stat) {
                                if (data.data == 'success') {
                                    obj.update({
                                        email: value
                                    });
                                    layer.close(index);
                                }else{
                                    layer.close(index);
                                    layer.msg('操作失败');
                                }
                            });
                          });"),
                    ],
                    'delete' => [
                        'options' => [],
                        'content' =>  Html::a("删除",'#',[
                            'class' => 'layui-btn layui-btn-xs layui-btn-danger',
                            'lay-event' => 'delete',
                        ]),
                        'script' => new \yii\web\JsExpression("
                            layer.msg('确定删除' + data.bank_name + '?');
                        "),
                    ],

                ],
            ],
        ],
    ]); ?>

</div>
