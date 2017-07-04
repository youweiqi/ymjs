<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Logistics */

$this->title = 'Create Logistics';
$this->params['breadcrumbs'][] = ['label' => 'Logistics', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="logistics-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
