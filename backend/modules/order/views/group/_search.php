<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\order\models\search\GroupSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-info-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'options' => [
            'class'=>'form-inline',
            'role'=> 'form',
            'style'=> 'padding:10px 10px;border:1px solid #FFFFFF;margin-bottom:20px;'
        ],
        'method' => 'get',
        'fieldConfig' => [
            'template' => "<div style='margin:auto 20px'>{label}&nbsp;&nbsp; {input}</div>",
        ]



    ]); ?>

    <div class="" style="margin-top:5px">

        <?= $form->field($model, 'order_sn') ?>

        <?= $form->field($model, 'user_name')->label('会员') ?>

        <?php  echo $form->field($model, 'link_man') ?>

        <div class="" style="margin-top:5px">

            <?php  echo $form->field($model, 'store_name') ?>

            <?php  echo $form->field($model, 'mobile') ?>

            <?php  echo $form->field($model, 'refund')->dropDownList([''=>'全部','0'=>'否','1'=>'是']) ?>

            <div class="" style="margin-top:20px;margin-left:18px">
                <?= Html::submitButton('搜索', ['class' => 'btn btn-primary btn-sm','value'=>'search','name' => 'sub']) ?>
                <?= Html::resetButton('重置', ['class' => 'btn btn-default btn-sm']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
