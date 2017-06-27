<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TeamUserRelation */

$this->title = 'Update Team User Relation: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Team User Relations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="team-user-relation-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
