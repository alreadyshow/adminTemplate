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
