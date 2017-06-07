<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\BusinessCircle */

$this->title = 'Create Business Circle';
$this->params['breadcrumbs'][] = ['label' => 'Business Circles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="business-circle-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
