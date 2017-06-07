<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;


/* @var $this yii\web\View */
/* @var $model common\models\RedeemCode */

$this->title = '新增兑换码';
$this->params['breadcrumbs'][] = ['label' => '兑换码管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="redeem-code-batch-create">

    <div class="redeem-code-form">

        <?php $form = ActiveForm::begin([
            'options' => ['class' => 'form-horizontal'],
            'fieldConfig' => [
                'template' => "<div class='col-md-2 text-right'>{label} :</div><div class='col-md-4'>{input}</div><div class='col-md-6 col-md-offset-0'>{error}</div>",
            ]
        ]); ?>

        <?= $form->field($model, 'create_quantity')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'usable_times')->textInput() ?>

        <?= $form->field($model, 'remark')->textInput() ?>

        <?=  $form->field($model, 'promotion_id')->hint('<span style="color: #ff0000;">*</span>')->label('优惠礼包')->widget(Select2::classname(),  [
            'options' => ['placeholder' => '请选择优惠礼包...'],
            'data' => isset($Promotion_data)?$Promotion_data:[],
            'pluginOptions' => [
                'allowClear' => true,
                'language'=>[
                    'errorLoading'=>new JsExpression("function(){return 'Waiting...'}")
                ],
                'ajax' => [
                    'url' => \yii\helpers\Url::to(['/discount/redeem-code/search-promotion']),
                    'dataType' => 'json',
                    'data' => new JsExpression('function(params) { return {name:params.term}; }')
                ],
                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                'templateResult' => new JsExpression('function(res) { return res.text; }'),
                'templateSelection' => new JsExpression('function (res) { return res.text; }'),
            ],
        ]); ?>

        <?= $form->field($model, 'start_date')->widget(DateTimePicker::classname(), [
            'options' => ['placeholder' => ''],
            'removeButton' => false,
            'pluginOptions' => [
                'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
                'autoclose' => true,
                'startDate' => date('Y-m'),
                'minView' => 1,
                'format' => 'yyyy-mm-dd hh:00:00'
            ]
        ]); ?>

        <?= $form->field($model, 'end_date')->widget(DateTimePicker::classname(), [
            'options' => ['placeholder' => ''],
            'removeButton' => false,
            'pluginOptions' => [
                'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
                'autoclose' => true,
                'startDate' => date('Y-m'),
                'minView' => 1,
                'format' => 'yyyy-mm-dd hh:00:00'
            ]
        ]); ?>

        <div class="form-group">
            <div class="col-md-3"></div>
            <div class="col-md-3">
                <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
            </div>
            <div class="col-md-6 col-md-offset-0"></div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
