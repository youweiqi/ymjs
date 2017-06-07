<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Inventory */

$this->title = '添加库存';
$this->params['breadcrumbs'][] = ['label' => 'Inventories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inventory-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
