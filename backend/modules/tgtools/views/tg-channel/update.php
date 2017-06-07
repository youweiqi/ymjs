<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TgChannel */

$this->title = 'Update Tg Channel: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Tg Channels', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tg-channel-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
