<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Store */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Stores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="store-view">

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
            'supplier_id',
            'store_name',
            'money',
            'logo_path',
            'back_image_path',
            'province',
            'city',
            'area',
            'address',
            'settlement_account',
            'settlement_bank',
            'settlement_man',
            'settlement_interval',
            'open_flash_express',
            'flash_express_begin_time',
            'flash_express_end_time',
            'open_install',
            'install_begin_time',
            'install_end_time',
            'open_express',
            'store_type',
            'is_show_commit',
            'is_show_map',
            'is_modify_inventory',
            'tel',
            'checkout_type',
            'commisionlimit',
            'lon',
            'lat',
            'price_no_freight',
            'cooperate_type',
            'agent_user_id',
            'agent_user_id3',
            'agent_user_id6',
            'commision_target',
            'sale_target',
            'channel',
            'create_time',
            'update_time',
            'status',
            'qr_code',
            'distance',
        ],
    ]) ?>

</div>
