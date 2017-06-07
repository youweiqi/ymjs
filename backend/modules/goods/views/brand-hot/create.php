<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\BrandHot */

$this->title = 'Create Brand Hot';
$this->params['breadcrumbs'][] = ['label' => 'Brand Hots', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="brand-hot-create">

    <?= $this->render('_form', [
        'model' => $model,
        'brand_hot_name_data'=>$brand_hot_name_data,
    ]) ?>

</div>
