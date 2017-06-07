<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\SpecificationDetail */

$this->title = 'Create Specification Detail';
$this->params['breadcrumbs'][] = ['label' => 'Specification Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="specification-detail-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
