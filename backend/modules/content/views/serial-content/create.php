<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\SerialContent */

$this->title = 'Create Serial Content';
$this->params['breadcrumbs'][] = ['label' => 'Serial Contents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="serial-content-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
