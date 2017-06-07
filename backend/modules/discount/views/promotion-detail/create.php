<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\PromotionDetail */

$this->title = 'Create Promotion Detail';
$this->params['breadcrumbs'][] = ['label' => 'Promotion Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="promotion-detail-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
