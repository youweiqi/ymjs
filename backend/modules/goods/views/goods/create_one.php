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

$this->title = '新增商品';
$this->params['breadcrumbs'][] = ['label' => '商品列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goods-create">

    <div class="goods-form">

        <?php $form = ActiveForm::begin([
            'options' => ['class' => 'form-horizontal'],
            'action' => Url::to(['/goods/goods/create','step'=>1]),
            'fieldConfig' => [
                'template' => "<div class='col-md-2 text-right'>{label} :</div><div class='col-md-4'>{input}</div><div class='col-md-6 col-md-offset-0'>{error}</div>",
            ]
        ]); ?>

        <?= $form->field($model,'goods_code')->textInput(['maxlength' => true]) ?>

        <?=  $form->field($model,'brand_id')->label('品牌')->widget(Select2::classname(), [
            'options' => ['placeholder' => '请输入品牌名称...'],
            'data' => isset($brand_data)?$brand_data:[],
            'pluginOptions' => [
                'allowClear' => true,
                'ajax' => [
                    'url' => Url::to(['/goods/brand/search-brand']),
                    'dataType' => 'json',
                    'data' => new JsExpression('function(params) { return {brand_name:params.term}; }')
                ],
                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                'templateResult' => new JsExpression('function(res) { return res.text; }'),
                'templateSelection' => new JsExpression('function (res) { return res.text; }'),
            ],
        ]); ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'label_name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'suggested_price')->textInput() ?>

        <?= $form->field($model, 'category_parent_id')->label('父分类名称')->dropDownList(ArrayHelper::map(CategoryLib::getParentCategories(),'id','name'),
            [
                'prompt' => '请选择父分类',
            ]) ?>

        <?= $form->field($model, 'category_id')->label('子分类名称')->dropDownList(ArrayHelper::map(CategoryLib::getChildCategories($model->category_parent_id),'id','name'),
            [
                'prompt' => '请选择子分类',
            ]) ?>

        <?= $form->field($model, 'ascription')->dropDownList(['1'=>'正常商品']) ?>

        <?= $form->field($model, 'channel')->dropDownList(['1'=>'电商','3'=>'海淘']) ?>

        <?=  $form->field($model, 'service_ids')->label('服务项目')->widget(Select2::classname(), [
            'options' => ['placeholder' => '请输入项目名称...','multiple' => true],
            'data' => isset($store_brand_data)?$store_brand_data:[],
            'pluginOptions' => [
                'allowClear' => true,
                'ajax' => [
                    'url' => Url::to(['/goods/goods-service/search-goods-service']),
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
                <?= Html::submitButton('下一步', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
            <div class="col-xs-12 col-xs-offset-3"></div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>


</div>
<?php
$this->registerJs('
    $("#goods-category_parent_id").change(function() {
        var category_parent_id = $(this).val();
        $("#goods-category_id").html("<option value=\"0\">请选择子分类</option>");
        if (category_parent_id!=0) {
            getChildCategories(category_parent_id);
        }
    });

    function getChildCategories(category_parent_id)
    {
        var href = "'.Url::to(['/goods/category/get-child-categories']).'";
        $.ajax({
            "type"  : "POST",
            "url"   : href,
            "data"  : {category_id : category_parent_id},
            success : function(data) {
                $("#goods-category_id").append(data);
            }
        });
    }
');
?>
