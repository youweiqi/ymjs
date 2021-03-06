<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SystemBizConfig */

$this->title = 'Update System Biz Config: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'System Biz Configs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="system-biz-config-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
