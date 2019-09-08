<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TSBankAgentCode */

$this->title = Yii::t('norm', 'Update Ts Bank Agent Code: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('norm', 'Ts Bank Agent Codes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('norm', 'Update');
?>
<div class="tsbank-agent-code-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
