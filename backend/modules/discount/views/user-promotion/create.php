<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\UserPromotion */

$this->title = 'Create User Promotion';
$this->params['breadcrumbs'][] = ['label' => 'User Promotions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-promotion-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
