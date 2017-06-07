<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\FreightTemplate */

$this->title = 'Create Freight Template';
$this->params['breadcrumbs'][] = ['label' => 'Freight Templates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="freight-template-create">

    <?= $this->render('_form', [
        'model' => $model,
        'province_form' => $province_form,
    ]) ?>

</div>
