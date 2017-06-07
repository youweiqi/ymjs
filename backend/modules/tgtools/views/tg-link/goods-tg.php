<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model common\models\TgLink */

$this->title = '新增商品券推广链接';
?>
<div class="tg-channel-create">
    <div class="tg-channel-form">

        <?php $form = ActiveForm::begin([
            'id' => 'content_form',
            'enableAjaxValidation' => true,
            'validationUrl' => Url::toRoute(['goods-tg-validate-form']),
            'options' => [
                'class'=>'form-horizontal',
                'style'=> 'padding:5px 5px;border:1px solid #D8DCE3;x;'
            ],
            'fieldConfig' => [
                'template' => "<div class='col-sm-4 text-right'>{label}:</div><div class='col-sm-4'>{input}</div><div>{hint}</div><div class='col-sm-4 col-sm-offset-0'>{error}</div>",
            ]
        ]); ?>
        <?=  $form->field($model, 'channel_id')->label('选择渠道')->widget(Select2::classname(), [
            'options' => ['placeholder' => '请输入渠道名称...'],
//            'data' => isset($serial_brand_data)?$serial_brand_data:[],
            'data' => $model->channelArrayData,
            'pluginOptions' => [
                'allowClear' => true,
                'ajax' => [
                    'url' => \yii\helpers\Url::to(['/tgtools/tg-channel/search-channel']),
                    'dataType' => 'json',
                    'data' => new JsExpression('
                    function(params) { 
                        return {channel_name:params.term}; 
                    }
                    ')
                ],
                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                'templateResult' => new JsExpression('function(res) { return res.text; }'),
                'templateSelection' => new JsExpression('function (res) { return res.text; }'),
            ],
        ]);
        ?>
        <?=  $form->field($model, 'promotion_detail_id')->label('选择商品券')->widget(Select2::classname(), [
            'options' => ['placeholder' => '请输入商品券名称...'],
//            'data' => isset($serial_brand_data)?$serial_brand_data:[],
            'data' => $model->promotionDetailArrayData,
            'pluginOptions' => [
                'allowClear' => true,
                'ajax' => [
                    'url' => \yii\helpers\Url::to(['/discount/promotion-detail/search-promotion-detail']),
                    'dataType' => 'json',
                    'data' => new JsExpression('
                    function(params) { 
                        return {promotion_detail_name:params.term,type:5}; 
                    }
                    ')
                ],
                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                'templateResult' => new JsExpression('function(res) { return res.text; }'),
                'templateSelection' => new JsExpression('function (res) { return res.text; }'),
            ],
        ]);
        ?>
        <?= $form->field($model, 'promotion_total_num')->label('此连接总可发券数')->textInput(['value'=>($model->isNewRecord?'1000':$model->promotion_total_num),'maxlength' => true]) ?>
        <?= $form->field($model, 'promotion_person_num')->label('每个用户可领取券数')->textInput(['value'=>($model->isNewRecord?'10':$model->promotion_person_num),'maxlength' => true]) ?>
        <?= $form->field($model, 'memo')->label('描述')->textarea(['maxlength' => true]) ?>


        <div class="form-group" style="text-align:center">
            <?= Html::submitButton('生成链接', ['class' => 'btn btn-success']) ?>
            <?= Html::button('关闭', ['class' => 'btn btn-primary','data-dismiss'=>'modal']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>


</div>
