<?php

use kartik\widgets\DateTimePicker;
use kartik\widgets\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Activity */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="activity-form">

    <?php $form = ActiveForm::begin([
        'id' => 'activity_form',
        'enableAjaxValidation' => true,
        'validationUrl' => Url::toRoute(['validate-form','id'=>$model->isNewRecord?null:$model->id]),
        'options' => [
            'class'=>'form-horizontal',
            'style'=> 'padding:15px 15px;border:1px solid #D8DCE3;x;'
        ],
        'fieldConfig' => [
            'template' => "<div class='col-sm-3 text-right'>{label}:</div><div class='col-sm-6'>{input}</div><div>{hint}</div><div class='col-sm-3 col-sm-offset-0'>{error}</div>",
        ]
    ]); ?>
    <div style="width:100%;height:40px;background-color:#D8DCE3;line-height:40px;color:#696C75;padding-left:20px;margin-bottom:10px;">基本信息</div>

    <?=  $form->field($model, 'store_id')->label('店铺名称')->widget(Select2::classname(), [
        'options' => ['placeholder' => '请输入店铺名称...'],
        'data' => isset($store_data)?$store_data:[],
        'pluginOptions' => [
            'allowClear' => true,
            'ajax' => [
                'url' => Url::to(['/warehouse/store/search-store']),
                'dataType' => 'json',
                'data' => new JsExpression('function(params) { return {store_name:params.term}; }')
            ],
            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            'templateResult' => new JsExpression('function(res) { return res.text; }'),
            'templateSelection' => new JsExpression('function (res) { return res.text; }'),
        ],
    ]); ?>

    <?=  $form->field($model, 'good_id')->label('商品名称')->widget(Select2::classname(), [
        'options' => ['placeholder' => '请输入商品名称...'],
        'data' => isset($goods_data)?$goods_data:[],
        'pluginOptions' => [
            'allowClear' => true,
            'ajax' => [
                'url' => Url::to(['/content/activity/search-goods']),
                'dataType' => 'json',
                'data' => new JsExpression('function(params) {
                     var store_id = $("#activity-store_id option:selected").val();
                     console.log(store_id);
                     if(!store_id){
                        alert("请先选择店铺");
                     }else{
                        return {goods_name:params.term,store_id:store_id};
                     }
                     }')
            ],
            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            'templateResult' => new JsExpression('function(res) { return res.text; }'),
            'templateSelection' => new JsExpression('function (res) { return res.text; }'),
        ],
    ]); ?>



    <?= $form->field($model, 'sale_price')->textInput() ?>

    <?= $form->field($model, 'start_time')->widget(DateTimePicker::classname(), [
        'options' => ['placeholder' => ''],
        'removeButton' => false,
        'pluginOptions' => [
            'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
            'autoclose' => true,
            'startDate' => date('Y-m'),
            'minView' => 1,
            'format' => 'yyyy-mm-dd hh:ii:00'
        ]
    ]); ?>

    <?= $form->field($model, 'end_time')->widget(DateTimePicker::classname(), [
        'options' => ['placeholder' => ''],
        'removeButton' => false,
        'pluginOptions' => [
            'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
            'autoclose' => true,
            'startDate' => date('Y-m'),
            'minView' => 1,
            'format' => 'yyyy-mm-dd hh:ii:00'
        ]
    ]); ?>

    <?= $form->field($model, 'type')->radioList(['2'=>'福利社',]) ?>

    <input id="activity-details" class="form-control" name="activity_details" type="hidden">
    <div style="width:100%;height:40px;background-color:#D8DCE3;line-height:40px;color:#696C75;padding-left:20px;margin-bottom:10px;">详情信息<button type='button' id="activity_detail_initialize" class="btn btn-success" style="float: right;margin-right: 20px">初始化</button></div>
    <div>
        <table id="activity_detail" class="table table-striped">
            <thead>
            <tr>
                <th style="text-align:center" >货品ID</th>
                <th style="text-align:center" >货号</th>
                <th style="text-align:center" >福利数量(可点击)</th>
                <th class="hidden" style="text-align:center">库存ID</th>
                <th style="text-align:center" >操作</th>
            </tr>
            </thead>
            <tbody>
            <?php if (isset($activity_details)&&!empty($activity_details)){
                foreach ($activity_details as $activity_detail){
                    echo "<tr>
                <td class='col-sm-2' style='text-align:center'>$activity_detail->product_id</td>
                <td class='col-sm-2' style='text-align:center'>$activity_detail->product_bn</td>
                <td class='col-sm-2' style='text-align:center' onclick='tdclick(this)'>$activity_detail->inventory_num</td>
                <td class='hidden col-sm-1'>$activity_detail->inventory_id</td>
                <td class='col-sm-1' style='text-align:center; ' onclick='deletetr(this)'>
                    <button type='button'  class='btn btn-xs btn-link'>删除</button>
                </td>
                
            </tr>";
                }
            }
            ?>
            </tbody>
        </table>

    </div>
    <hr>
    <div class="form-group" style="text-align:center">
        <button id="submit_form_btn" class="btn btn-success" style="margin-right: 20px">保存</button>
        <?= Html::button('关闭', ['class' => 'btn btn-primary','data-dismiss'=>'modal']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$this->registerJs('
$("#submit_form_btn").click(function() {
        var activity_details = gettableinfo();
        $("#activity-details").val(activity_details);
        $("#activity-form").submit();
    });
$("#activity_detail_initialize").click(function() {
    var goods_id = $("#activity-good_id option:selected").val();
    var store_id = $("#activity-store_id option:selected").val();
    $.post("/content/activity-detail/initialize",{ goods_id:goods_id,store_id:store_id },
        function(data){
            if(data){
                var data = $.parseJSON(data); 
                var tbody = "";
                $.each(data,function(key,value) {   
                     tbody += "<tr><td class=\'col-sm-3\' style=\'text-align:center\'>"+value.product_id+"</td><td class=\'col-sm-3\' style=\'text-align:center\'>"+value.product_bn+"</td><td class=\'col-sm-3\' style=\'text-align:center\' onclick=\'tdclick(this)\'>"+value.inventory_num+"</td><td class=\'hidden col-sm-1\'>"+value.inventory_id+"</td><td class=\'col-sm-2 \' style=\'text-align:center; \' onclick=\'deletetr(this)\'><button type=\'button\'  class=\'btn btn-xs btn-link\'>删除</button></td></tr>";
                });
                $("#activity_detail tbody").html(tbody);  
            }
    });
});
function gettableinfo(){  
    var key = "";  
    var val = "";  
    var value = "";  
    var tabledata = "";  
    var table = $("#activity_detail");
    var tbody = table.children();  
    var trs = tbody.children();  
    for(var i=1;i<trs.length;i++){  
        var tds = trs.eq(i).children();  
        for(var j=0;j<tds.length;j++){  
            if(j==0){  
                if(tds.eq(j).text()==null||tds.eq(j).text()==""){  
                    return null;  
                }  
                key = "product_id\":\""+tds.eq(j).text();  
            }  
            if(j==2){  
                if(tds.eq(j).text()==null||tds.eq(j).text()==""){  
                    return null;  
                }  
                val = "inventory_num\":\""+tds.eq(j).text();  
            }  
            if(j==3){  
                if(tds.eq(j).text()==null||tds.eq(j).text()==""){  
                    return null;  
                }  
                value = "inventory_id\":\""+tds.eq(j).text();  
            } 
        }  
        if(i==trs.length-1){  
            tabledata += "{\""+key+"\",\""+val+"\",\""+value+"\"}";  
        }else{  
            tabledata += "{\""+key+"\",\""+val+"\",\""+value+"\"},";  
        }  
    }  
    tabledata = "["+tabledata+"]";  
    return tabledata;  
}  
  
function tdclick(tdobject){  
    var td=$(tdobject);  
    td.attr("onclick", "");  
    var text=td.text();  
    td.html(""); 
    var input=$("<input>");  
    input.attr("value",text);  
    input.bind("blur",function(){  
        var inputnode=$(this);  
        var inputtext=inputnode.val();  
        var tdNode=inputnode.parent();  
        tdNode.html(inputtext);  
        tdNode.click(tdclick);  
        td.attr("onclick", "tdclick(this)");  
    });  
    input.keyup(function(event){  
        var myEvent =event||window.event;  
        var kcode=myEvent.keyCode;  
        if(kcode==13){  
            var inputnode=$(this);  
            var inputtext=inputnode.val();  
            var tdNode=inputnode.parent();  
            tdNode.html(inputtext);  
            tdNode.click(tdclick);  
        }  
    });   
    td.append(input);  
    var t =input.val();  
    input.val("").focus().val(t);   
    td.unbind("click");  
} 
function deletetr(tdobject){  
    var td=$(tdobject);  
    td.parents("tr").remove();  
} 
');
?>

