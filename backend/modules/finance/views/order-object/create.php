<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\OrderObject */

$this->title = 'Create Order Object';
$this->params['breadcrumbs'][] = ['label' => 'Order Objects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-object-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
