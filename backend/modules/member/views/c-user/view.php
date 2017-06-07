<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\CUser */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Cusers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cuser-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user_name',
            'password',
            'role_id',
            'old_role_id',
            'background_image',
            'nick_name',
            'picture',
            'lock_status',
            'is_black',
            'money',
            'synopsis:ntext',
            'talent_effect_time',
            'talent_failure_time',
            'empiric_value',
            'total_cost',
            'total_sale',
            'recommend_from',
            'member_recommend',
            'talent_teacher',
            'last_login_time',
            'create_time',
            'update_time',
            'fans_count',
            'remain_sales_quota',
            'remark',
            'total_cost_score',
        ],
    ]) ?>

</div>
