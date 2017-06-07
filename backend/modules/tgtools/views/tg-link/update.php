<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TgLink */

$this->title = 'Update Tg Link: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tg Links', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tg-link-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
