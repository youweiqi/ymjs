<?php

use backend\libraries\CategoryLib;
use backend\libraries\GoodsChannelLib;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use backend\assets\FlowPathAsset;

/* @var $this yii\web\View */
/* @var $model common\models\Goods */

$this->title = '更新商品';
$this->params['breadcrumbs'][] = ['label' => '商品列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goods-update-base">

    <div class="goods-form">

        <?php $form = ActiveForm::begin([
            'options' => ['class' => 'form-horizontal'],
            'action' => Url::to(['/goods/goods/update-base','id'=>$model->id]),
            'fieldConfig' => [
                'template' => "<div class='col-md-2 text-right'>{label} :</div><div class='col-md-4'>{input}</div><div class='col-md-6 col-md-offset-0'>{error}</div>",
            ]
        ]); ?>

        <?= $form->field($model,'goods_code')->textInput(['readonly' => 'readonly']) ?>

        <?= $form->field($model,'label_name')->textInput(['maxlength' => true]) ?>

        <?=  $form->field($model,'brand_id')->label('品牌')->widget(Select2::classname(), [
            'options' => ['placeholder' => '请输入品牌名称...'],
            'data' => isset($brand_data)?$brand_data:[],
            'pluginOptions' => [
                'allowClear' => true,
                'ajax' => [
                    'url' => Url::to(['/brand/brand/search-brand']),
                    'dataType' => 'json',
                    'data' => new JsExpression('function(params) { return {brand_name:params.term}; }')
                ],
                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                'templateResult' => new JsExpression('function(res) { return res.text; }'),
                'templateSelection' => new JsExpression('function (res) { return res.text; }'),
            ],
        ]); ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'suggested_price')->textInput() ?>

        <?=  $form->field($model, 'category_parent_id')->hint('<span style="color: #ff0000;">*</span>')->label('二级分类')->widget(Select2::classname(), [
            'options' => ['placeholder' => '请选择二级分类...'],
            'data' => isset($parent_category_data)?$parent_category_data:[],
            'pluginOptions' => [
                'allowClear' => true,
                'ajax' => [
                    'url' => Url::to(['/brand/category/search-category']),
                    'dataType' => 'json',
                    'data' => new JsExpression('function(params) {
                        var brand_id = $("#goods-brand_id").val();
                        if(brand_id){
                            return {name:params.term,brand_id:brand_id};
                        }else{
                            alert("请先选择品牌");
                        }
                     }')
                ],
                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                'templateResult' => new JsExpression('function(res) { return res.text; }'),
                'templateSelection' => new JsExpression('function (res) { return res.text; }'),
            ],
        ]); ?>

        <?=  $form->field($model, 'category_id')->hint('<span style="color: #ff0000;">*</span>')->label('三级分类')->widget(Select2::classname(), [
            'options' => ['placeholder' => '请选择三级分类...'],
            'data' => isset($category_data)?$category_data:[],
            'pluginOptions' => [
                'allowClear' => true,
                'ajax' => [
                    'url' => Url::to(['/brand/category/search-child-category']),
                    'dataType' => 'json',
                    'data' => new JsExpression('function(params) {
                        var parent_id = $("#goods-category_parent_id").val();
                        if(parent_id){
                            return {name:params.term,category_id:parent_id};
                        }else{
                            alert("请先选择二级分类");
                        }
                     }')
                ],
                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                'templateResult' => new JsExpression('function(res) { return res.text; }'),
                'templateSelection' => new JsExpression('function (res) { return res.text; }'),
            ],
        ]); ?>

        <?=  $form->field($model, 'service_ids')->label('服务项目')->widget(Select2::classname(), [
            'options' => ['placeholder' => '请输入项目名称...','multiple' => true],
            'data' => isset($goods_service_data)?$goods_service_data:[],
            'pluginOptions' => [
                'allowClear' => true,
                'ajax' => [
                    'url' => Url::to(['/brand/goods-service/search-goods-service']),
                    'dataType' => 'json',
                    'data' => new JsExpression('function(params) { return {service_name:params.term}; }')
                ],
                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                'templateResult' => new JsExpression('function(res) { return res.text; }'),
                'templateSelection' => new JsExpression('function (res) { return res.text; }'),
            ],
        ]); ?>
        <div class="form-group">
            <div class="col-xs-3"></div>
            <div class="col-xs-9">
                <?= Html::submitButton('下一步', ['class' => 'btn btn-primary']) ?>
            </div>
            <div class="col-xs-12 col-xs-offset-3"></div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>


</div>

