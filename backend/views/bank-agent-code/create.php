<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TSBankAgentCode */

$this->title = Yii::t('norm', 'Create Ts Bank Agent Code');
$this->params['breadcrumbs'][] = ['label' => Yii::t('norm', 'Ts Bank Agent Codes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tsbank-agent-code-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
