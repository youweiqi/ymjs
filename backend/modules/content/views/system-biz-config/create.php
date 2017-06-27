<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\SystemBizConfig */

$this->title = 'Create System Biz Config';
$this->params['breadcrumbs'][] = ['label' => 'System Biz Configs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="system-biz-config-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
