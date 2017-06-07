<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\RedeemCode */

$this->title = 'Create Redeem Code';
$this->params['breadcrumbs'][] = ['label' => 'Redeem Codes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="redeem-code-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
