<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TalentSerial */

$this->title = 'Update Talent Serial: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Talent Serials', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="talent-serial-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
