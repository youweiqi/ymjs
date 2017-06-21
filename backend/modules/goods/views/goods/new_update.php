<?php

use backend\libraries\CategoryLib;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use backend\assets\GoodsNewAsset;


/* @var $this yii\web\View */

$this->title = '新增商品';
$this->params['breadcrumbs'][] = ['label' => '商品列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
GoodsNewAsset::register($this);
?>
<!--<script src="https://unpkg.com/vue/dist/vue.js"></script>-->
<div style="max-width: 1200px;height: auto;margin: 0 auto;background: #ffffff;border: 1px solid #d8d8d8;">
<!--    <div class="goods-form">-->
        <?php $form = ActiveForm::begin([
            'options' => ['class' => 'form-horizontal'],
            'action' => Url::to(['/goods/goods/update-goods','id'=>$data['model']->id]),
            'fieldConfig' => [
                'template' => "<div class='col-md-2 text-right'>{label} :</div><div class='col-md-4'>{input}</div><div class='col-md-6 col-md-offset-0'>{error}</div>",
            ]
        ]); ?>
        <!--one step begin-->
        <div class="one-step">
            <div class="body-head">
                <span class="body-title">编辑商品基本信息</span>
            </div>
        <?= $form->field($data['model'],'goods_code')->textInput(['maxlength' => true]) ?>

        <?=  $form->field($data['model'],'brand_id')->label('品牌')->widget(Select2::classname(), [
            'options' => ['placeholder' => '请输入品牌名称...'],
            'data' => isset($data['brand_data'])?$data['brand_data']:[],
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

        <?= $form->field($data['model'], 'name')->textInput(['maxlength' => true]) ?>

            <?php //echo $form->field($model, 'label_name')->textInput(['maxlength' => true]); ?>

        <?= $form->field($data['model'], 'suggested_price')->textInput() ?>

        <?= $form->field($data['model'], 'category_parent_id')->label('父分类名称')->dropDownList(ArrayHelper::map(CategoryLib::getParentCategories(),'id','name'),
            [
                'prompt' => '请选择父分类',
            ]) ?>

        <?= $form->field($data['model'], 'category_id')->label('子分类名称')->dropDownList(ArrayHelper::map(CategoryLib::getChildCategories($data['model']->category_parent_id),'id','name'),
            [
                'prompt' => '请选择子分类',
            ]) ?>

        <?= $form->field($data['model'], 'ascription')->dropDownList(['1'=>'正常商品']) ?>

        <?= $form->field($data['model'], 'channel')->dropDownList(['1'=>'电商','3'=>'海淘']) ?>

        <?php
//        echo $form->field($data['model'], 'service_ids')->label('服务项目')->widget(Select2::classname(), [
//            'options' => ['placeholder' => '请输入项目名称...','multiple' => true],
//            'data' => $data['goods_services'],
//            'pluginOptions' => [
//                'allowClear' => true,
//                'ajax' => [
//                    'url' => Url::to(['/goods/goods-service/search-goods-service']),
//                    'dataType' => 'json',
//                    'data' => new JsExpression('function(params) { return {service_name:params.term}; }')
//                ],
//                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
//                'templateResult' => new JsExpression('function(res) { return res.text; }'),
//                'templateSelection' => new JsExpression('function (res) { return res.text; }'),
//            ],
//        ]);
        ?>
        <div class="form-group">
            <div class="col-xs-3"></div>
            <div class="col-xs-9">
                <?= Html::button('下一步', ['class' => 'btn btn-success one-to-two']) ?>
            </div>
            <div class="col-xs-12 col-xs-offset-3"></div>
        </div>
        </div>
        <!--one step end--->
        <div class="norms-warp two-step" style="display: none;">
            <input type="hidden" id="goods_brand_id" value="<?php echo $brand_id??'' ;?>"/>
            <div class="body-head">
                <span class="body-title">编辑规格和规格值</span>
            </div>
            <div class="product-form">
                <div class="form-group  spec_pool" style="margin-left: 12px;margin-right: 12px;">
                    <div class="spec_input"  style="">
                        <?php foreach ($data['specGlobalInfo'] as $key=>$spec) {?>
                        <div class="one_spec_select one_spec_select_1 clearfix" data-index="<?=$key?>">
                            <div class="select_spec_name">
                                <div class="result_list result_list_1" style="display: none;">
                                    <div class="list-group" style="overflow-x: hidden;overflow-y: auto;max-height:200px;border-bottom: 1px solid #ddd;margin-bottom:0px">
                                        <a class="list-group-item" style="border-radius:0;" data-id="" data-name="">查询中...</a>
                                    </div>
                                    <button class="spec-remove " style="" type="button" ">×</button>
                                </div>
                                <div class="spec_name_box" style="display: block">
                                    <div style="position: relative;display: inline-block;">
                                        <input type="text"  value="<?=$spec['name']?>" name="spec_name_input_1[]" class="spec_name_input_1 form-control inline spec_name_input inline" data-value="<?=$spec['id']?>" placeholder="输入规格检索或新建"">
                                        <i class="fa fa-fw fa-times clear_diyinput_value"></i>
                                    </div>
                                    <button class="btn btn-primary name_confirm_input" type="button" data-index="1" style="margin-left: 5px;">确定</button>
                                </div>
                            </div>
                            <div class="spec_value_box spec_value_box_1" >
                                <p style="width: 492px;padding-top: 10px;margin-left: 15px;">选项列表</p>
                                <div class="add_spec_value clearfix">
                                    <?php foreach ($spec['values'] as $k => $v){?>
                                    <div class="spec_value_tag">
                                        <button type="button" class="spec-close-value">×</button>
                                        <span class="spec_value_span" data-index="" data-id="<?=$v['id']?>" data-specid="<?=$spec['id']?>" data-value="<?=$v['value']?>"><?=$v['value']?></span>
                                    </div>
                                    <?php }?>
                                    <div class="add_spec_value_input add_spec_value_input_1" style="display: none">
                                        <div class="spec_name_box">
                                            <input type="text" class="spec_name_value_input_1 form-control inline spec_value_input"  placeholder="输入规格值检索或新建">
                                            <div class="result_list result_tag_list_1">
                                                <div class="list-group" style="overflow-x: hidden;overflow-y: auto;max-height:200px;border-bottom: 1px solid #ddd;margin-bottom:0px">
                                                    <a class="list-group-item" style="border-radius:0;" data-id="" data-name="">查询中...</a>
                                                </div>
                                                <button class="spec-remove" style=""  type="button" onclick="CloseResultTagList(1)">×</button>
                                            </div>
                                        </div>
                                        <button class="btn btn-primary confirm_input confirm_input_1" type="button" data-index="1" style="margin-left: 5px;">确定</button>
                                        <button class="btn btn-default cancle_value" type="button" style="margin-left:5px;">取消</button>
                                    </div>
                                    <button class="btn create-event-label" type="button"><span name="event_form_item_ctrl" class="icon-event-label-add"></span></button>
                                </div>
                            </div>
                        </div>
                        <?php }?>
                        <!--选项-->
                    </div>
                    <div id="spec_tpl" class="one_spec_select  clearfix"  style="display: none;">
                        <div class="select_spec_name">
                            <div class="result_list ">
                                <div class="list-group" style="overflow-x: hidden;overflow-y: auto;max-height:200px;border-bottom: 1px solid #ddd;margin-bottom:0px">
                                    <a class="list-group-item" style="border-radius:0;" data-id="" data-name="">查询中...</a>
                                </div>
                                <button class="spec-remove " style="" type="button" >×</button>
                            </div>
                            <div class="spec_name_box" style="display: block">
                                <div style="position: relative;display: inline-block;">
                                    <input type="text" name="spec_name_input_1[]" class="spec_name_input_1 form-control inline spec_name_input inline" data-value="" placeholder="输入规格检索或新建"">
                                    <i class="fa fa-fw fa-times clear_diyinput_value"></i>
                                </div>
                                <button class="btn btn-primary name_confirm_input" type="button" data-index="1" style="margin-left: 5px;">确定</button>
                            </div>
                        </div>
                        <div class="spec_value_box spec_value_box_1" >
                            <p style="width: 492px;padding-top: 10px;margin-left: 15px;">选项列表</p>
                            <div class="add_spec_value clearfix">
                                <div class="add_spec_value_input add_spec_value_input_1" style="display: none">
                                    <div class="spec_name_box">
                                        <input type="text" class="spec_name_value_input_1 form-control inline spec_value_input"  placeholder="输入规格值检索或新建">
                                        <div class="result_list result_tag_list_1">
                                            <div class="list-group" style="overflow-x: hidden;overflow-y: auto;max-height:200px;border-bottom: 1px solid #ddd;margin-bottom:0px">
                                                <a class="list-group-item" style="border-radius:0;" data-id="" data-name="">查询中...</a>
                                            </div>
                                            <button class="spec-remove" style=""  type="button" onclick="CloseResultTagList(1)">×</button>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary confirm_input confirm_input_1" type="button" data-index="1" style="margin-left: 5px;">确定</button>
                                    <button class="btn btn-default cancle_value" type="button" style="margin-left:5px;">取消</button>
                                </div>
                                <button class="btn create-event-label" type="button"><span name="event_form_item_ctrl" class="icon-event-label-add"></span></button>
                            </div>
                        </div>
                    </div>
                        <!--选项-->
                    <button type="button" class="btn-primary add_spec_btn" >添加规格</button>

                </div>
            </div>
            <p class="tips" id="set_all_num_tips" style="display: block;"><em>*</em>当市场价≠销售价时，商品价格将显示"销售价&nbsp;&nbsp;<span class="text-line-through">市场价</span>"；当市场价=销售价时，商品价格将只显示销售价。</p>
            <!--表格-->
            <div class="spec_table_box">
                <?php echo $data['product_table'];?>
            </div>
            <!--/表格-->
            <!--规格图-->
            <div class="spec_table_norms_box" style="display: <?=($data['spec_tbody']?'block':'none')?>">
                <table class="table table-bordered">
                    <table id="spec_norms_table" class="table table-bordered no-footer" style="margin-top: 20px; display: table;">
                        <thead id="spec_norms_table_thead_id">
                        <tr valign="middle">
                            <th style="width: 160px;" id="spec_norms_thead_name"></th>
                            <th >规格图</th>
                        </tr>
                        </thead>
                        <tbody id="spec_norms_table_tbody_id">
                        <?php echo $data['spec_tbody'];?>
                        </tbody>
                    </table>
                </table>
            </div>
            <input type="hidden" class="spec_info_string" name="Goods[spec_desc]" value="">
            <!--/规格图-->
            <!--提交下一步-->
            <div class="product-buttons">
                <button class="btn btn-primary  two-to-one" type="button" >上一步</button>
                <button class="btn btn-primary two-to-three" type="button" >下一步</button>
            </div>
        </div>
        <div class="banner-warp three-step" style="display: none">
            <div class="body-head">
                <span class="body-title">编辑商品海报图</span>
            </div>
            <div class="pro-abs-div" style="margin-top: 10px;">
                <p class="abs-info-tip"><em class="required" style="margin-right: 2px; margin-left: 0;">*</em> 1、图片比例1:1，建议尺寸800px*800px，本地上传图片大小不能超过500KB;</p>
                <p class="abs-info-tip info-tips-10">2、商品海报图为商品/活动详情页轮播图，最多可上传6张；</p>
            </div>
            <div class="slide-imgs">
                <div class="img-item">
                    <div class="change_img_div act_img_div">
                        <span class="change_img_btn"><i class="fa fa-chain"></i></span>
                        <?php
                        if(isset($data['goods_navigate'][0]))
                        {
                            echo '<img src="'.$data['goods_navigate'][0]['navigate_image'].'" class="thumbnail" name="goods_loopimgs[]" id="post_photo_pre1">';
                            echo '<input type="file" class="upload_img_banner" >';
                            echo '<input type="hidden" class="upload_img_banner_hidden" value="'.$data['goods_navigate'][0]['navigate_image'].'" name="upload_img[]">';
                        }else{
                            echo '<img src="../../statics/goods/images/600_400.png" class="thumbnail" name="goods_loopimgs[]" id="post_photo_pre1">';
                            echo '<input type="file" class="upload_img_banner" >';
                            echo '<input type="hidden" class="upload_img_banner_hidden" name="upload_img[]">';
                        }
                        ?>
                    </div>
                </div>
                <div class="img-item">
                    <div class="change_img_div act_img_div">
                        <span class="change_img_btn"  ><i class="fa fa-chain"></i></span>
                        <?php
                        if(isset($data['goods_navigate'][1]))
                        {
                            echo '<img src="'.$data['goods_navigate'][1]['navigate_image'].'" class="thumbnail" name="goods_loopimgs[]" id="post_photo_pre1">';
                            echo '<input type="file" class="upload_img_banner" >';
                            echo '<input type="hidden" class="upload_img_banner_hidden" value="'.$data['goods_navigate'][1]['navigate_image'].'" name="upload_img[]">';
                        }else{
                            echo '<img src="../../statics/goods/images/600_400.png" class="thumbnail" name="goods_loopimgs[]" id="post_photo_pre1">';
                            echo '<input type="file" class="upload_img_banner" >';
                            echo '<input type="hidden" class="upload_img_banner_hidden" name="upload_img[]">';
                        }
                        ?>
                    </div>
                </div>
                <div class="img-item">
                    <div class="change_img_div act_img_div">
                        <span class="change_img_btn"  ><i class="fa fa-chain"></i></span>
                        <?php
                        if(isset($data['goods_navigate'][2]))
                        {
                            echo '<img src="'.$data['goods_navigate'][2]['navigate_image'].'" class="thumbnail" name="goods_loopimgs[]" id="post_photo_pre1">';
                            echo '<input type="file" class="upload_img_banner" >';
                            echo '<input type="hidden" class="upload_img_banner_hidden" value="'.$data['goods_navigate'][2]['navigate_image'].'" name="upload_img[]">';
                        }else{
                            echo '<img src="../../statics/goods/images/600_400.png" class="thumbnail" name="goods_loopimgs[]" id="post_photo_pre1">';
                            echo '<input type="file" class="upload_img_banner" >';
                            echo '<input type="hidden" class="upload_img_banner_hidden" name="upload_img[]">';
                        }
                        ?>
                    </div>
                </div>
                <div class="img-item">
                    <div class="change_img_div act_img_div">
                        <span class="change_img_btn"  ><i class="fa fa-chain"></i></span>
                        <?php
                        if(isset($data['goods_navigate'][3]))
                        {
                            echo '<img src="'.$data['goods_navigate'][3]['navigate_image'].'" class="thumbnail" name="goods_loopimgs[]" id="post_photo_pre1">';
                            echo '<input type="file" class="upload_img_banner" >';
                            echo '<input type="hidden" class="upload_img_banner_hidden" value="'.$data['goods_navigate'][3]['navigate_image'].'" name="upload_img[]">';
                        }else{
                            echo '<img src="../../statics/goods/images/600_400.png" class="thumbnail" name="goods_loopimgs[]" id="post_photo_pre1">';
                            echo '<input type="file" class="upload_img_banner" >';
                            echo '<input type="hidden" class="upload_img_banner_hidden" name="upload_img[]">';
                        }
                        ?>
                    </div>
                </div>
                <div class="img-item">
                    <div class="change_img_div act_img_div">
                        <span class="change_img_btn"  ><i class="fa fa-chain"></i></span>
                        <?php
                        if(isset($data['goods_navigate'][4]))
                        {
                            echo '<img src="'.$data['goods_navigate'][4]['navigate_image'].'" class="thumbnail" name="goods_loopimgs[]" id="post_photo_pre1">';
                            echo '<input type="file" class="upload_img_banner" >';
                            echo '<input type="hidden" class="upload_img_banner_hidden" value="'.$data['goods_navigate'][4]['navigate_image'].'" name="upload_img[]">';
                        }else{
                            echo '<img src="../../statics/goods/images/600_400.png" class="thumbnail" name="goods_loopimgs[]" id="post_photo_pre1">';
                            echo '<input type="file" class="upload_img_banner" >';
                            echo '<input type="hidden" class="upload_img_banner_hidden" name="upload_img[]">';
                        }
                        ?>
                    </div>
                </div>
                <div class="img-item">
                    <div class="change_img_div act_img_div">
                        <span class="change_img_btn"  ><i class="fa fa-chain"></i></span>
                        <?php
                        if(isset($data['goods_navigate'][5]))
                        {
                            echo '<img src="'.$data['goods_navigate'][5]['navigate_image'].'" class="thumbnail" name="goods_loopimgs[]" id="post_photo_pre1">';
                            echo '<input type="file" class="upload_img_banner" >';
                            echo '<input type="hidden" class="upload_img_banner_hidden" value="'.$data['goods_navigate'][5]['navigate_image'].'" name="upload_img[]">';
                        }else{
                            echo '<img src="../../statics/goods/images/600_400.png" class="thumbnail" name="goods_loopimgs[]" id="post_photo_pre1">';
                            echo '<input type="file" class="upload_img_banner" >';
                            echo '<input type="hidden" class="upload_img_banner_hidden" name="upload_img[]">';
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="body-head">
                <span class="body-title">编辑商品详情图</span>
            </div>

            <div class="clearfix">
                <div class="device-warp">
                    <div class="device">
                        <div class="status-bar"></div>
                        <div class="window">
                            <div class="window-last-upload">
                                <?php
                                foreach ($data['goods_detail'] as $img)
                                {
                                    echo '<p class="del_last_img_index"><img  name="del_last_img_index[]"  src="'.$img['image_path'].'" ></p>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="last-upload-warp">
                    <div class="pro-abs-div" style="margin-top: 50px;">
                        <p class="abs-info-tip"><em class="required" style="margin-right: 2px; margin-left: 0;">*</em> 为保证最佳浏览效果，建议商品详情图片宽度为750px，高度不超过5000px（5屏）,单张小于500K。</p>
                        <p class="abs-info-tip info-tips-10">商品详情图为商品/活动详情页图。</p>
                    </div>
                    <div class="last-upload-btn-warp">
                        <div class="last-upload-btn-box">
                            <img src="../../statics/goods/images/last-last-upload-img.png" >
                            <input type="file" class="last-uploading-img" id="last-uploading-img">
                        </div>
                    </div>
                    <ul class="last-items-img mobile-img-list clearfix">
                        <?php
                        foreach ($data['goods_detail'] as $img)
                        {
                            echo '<li class="del_last_img_index"><img src="'.$img['image_path'].'"><input type="hidden" name="goodsDetailImg[]" value="'.$img['image_path'].'|'.$img['image_width'].'|'.$img['image_height'].'"><span class="del_img last_del_img close-modal">×</span></li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <!--banne图、详情图提交-->
            <div class="product-buttons">
                <button class="btn btn-primary three-to-two" type="button">上一步</button>
                <button id="goods-create-button" class="btn btn-primary" type="button">确认提交</button>
            </div>
        </div>


        <?php ActiveForm::end(); ?>
        <input type="hidden" id="goodsId" value="<?php echo $goods_id??'';?>">
        <div class="alert alert-danger form-alert-info" style="display: none" role="alert"></div>
        <div class="alert alert-success form-alert-info" style="display: none" role="alert"></div>
    </div>

</div>



<?php
$upload_img_url = Url::to(['/goods/goods/upload']);
$category = Url::to(['/goods/category/get-child-categories']);
$globalSpecStr = json_encode($data['specGlobalInfo']);
$js = <<<JS
function alertMsg(isOk,msg) {
    var alertBox =  isOk ? $(".alert-success"): $(".alert-danger");
    alertBox.html('<strong>提示: </strong>'+msg);
    alertBox.slideDown();
    setTimeout(function () {
        alertBox.slideUp();
    },2000);
}
//全局的规格信息
var globalSpecInfo = {$globalSpecStr};

$(function() {
    $("#goods-category_parent_id").change(function() {
        var category_parent_id = $(this).val();
        $("#goods-category_id").html("<option value=\"0\">请选择子分类</option>");
        if (category_parent_id!=0) {
            getChildCategories(category_parent_id);
        }
    });
    function getChildCategories(category_parent_id)
    {
        var href = "{$category}";
        $.ajax({
            "type"  : "POST",
            "url"   : href,
            "data"  : {category_id : category_parent_id},
            success : function(data) {
                $("#goods-category_id").append(data);
            }
        });
    }
   //点击第一页下一步
    $('.one-to-two').click(function() {
        if(oneToTwoCheck()){
            $('.one-step').hide();
            $('.two-step').show();
        }
        
    });
    function oneToTwoCheck() {
        var form = $("#w0"), 
        data = form.data("yiiActiveForm");
        $.each(data.attributes, function() {
            this.status = 3;
        });
        form.yiiActiveForm("validate");
        if (form.find(".has-error").length) {
            return false;
        }else{
            return true;
        }
    }
    //从第二页返回第一页
    $('.two-to-one').click(function() {
        if(checkTwo())
        {
            $('.one-step').show();
            $('.two-step').hide();
        }
        storeSpecInfoToInput();
    });
    //从第二页到第三页
    $('.two-to-three').click(function() {
        if(checkTwo())
        {
            $('.two-step').hide();
            $('.three-step').show();
        }
        storeSpecInfoToInput();
    });
    $('#goods-create-button').click(function(e) {
        console.log(e);
        if(checkThree()){
           $(this).closest('form').submit();
        }
    });
    function checkThree() {
        var navigate_glag = false;
        $('.upload_img_banner_hidden').each(function() {
            if($(this).val() !== ''){
                navigate_glag = true;
            }
        });
        if(navigate_glag === false)
        {
            alertMsg(false,'请至少上传一张轮播图');
            return false;
        }
        return true;
    }
    function checkTwo() {
        console.log(globalSpecInfo);
        var length =  globalSpecInfo.length;
        if(length < 1)
        {
            alertMsg(false,'请至少添加一个规格');
            return false;
        }
        for(var i = 0; i<length ; i++)
        {
            if(globalSpecInfo[i])
            {
                if(jQuery.isEmptyObject(globalSpecInfo[i]['values']))
                {
                    alertMsg(false,'请给规格'+globalSpecInfo[i]['name']+' 选添加规格值');
                    return false;
                }
            }
        }
        var  product_bn_flag = false;
        $("._product_bn").each(function() {
            if($.trim($(this).val()) == '')
            {
                product_bn_flag = true;
            }
        });
        if(product_bn_flag)
        {
            alertMsg(false,'请填写货号');
            return false;
        }
        var spec_img_flag = false;
        console.log($(".spec_image_hidden_input"));
        $(".spec_image_hidden_input").each(function(index,ele) {
            if($(this).val()==''){
                spec_img_flag = true;
            }
        });
        if(spec_img_flag){
            alertMsg(false,'请上传规格图');
            return false;
        }
        return true;
    }
    //从第三页返回第二页
    $('.three-to-two').click(function() {
        $('.two-step').show();
        $('.three-step').hide();
    });
    //将规格信息存储到隐藏input
    function storeSpecInfoToInput() {
        console.log(globalSpecInfo);
        var data = [];
        for(var i = 0; i < globalSpecInfo.length;i++)
        {
            data[i] = {
                'name':globalSpecInfo[i]['name'],
                'specificationId':globalSpecInfo[i]['id'],
                'value':[]
            };
            for(var j = 0; j < globalSpecInfo[i]['values'].length;j++ )
            {
                data[i]['value'][j] = {
                    'specificationDetailId' : globalSpecInfo[i]['values'][j]['id'],
                    'detailName' : globalSpecInfo[i]['values'][j]['value'],
                    'specificationDetailImage':''
                };
            }
        }
        
        var imageUrlInputs = $('.spec_image_hidden_input');
        imageUrlInputs.each(function() {
            for(var x = 0; x < data[0]['value'].length; x++ )
            {
                if($(this).attr('data-id') == data[0]['value'][x]['specificationDetailId'])
                {
                    data[0]['value'][x]['specificationDetailImage'] = $(this).val();
                }
            }
        });
        console.log(data);
        var specInfoString = JSON.stringify(data);
        $('.spec_info_string').val(specInfoString);
    }
    $('body').on('click','.cancle_value',function(){
        $(this).closest('.add_spec_value_input').hide();
    })
    $('body').on('click','.spec-remove',function(){
        $(this).closest('.result_list').hide();
    });
    // $('body').on('',".spec_name_input",function(){
    //     $(this).trigger("change");
    // });
    //点击规格检索 显示规格列表
    $('body').on('click','.name_confirm_input',function() {
        var _this = $(this);
        var specBlock = _this.closest('.one_spec_select');
        var specNameBlock = _this.closest('.select_spec_name');
        var index = specBlock.attr('data-index');
        var word = specNameBlock.find(".spec_name_input").val().replace(/(^\s*)|(\s*$)/g, "");
        var brand_id = $('#goods-brand_id').val();
        addSpec(index,word,brand_id,specNameBlock);

    })
    $('body').on("mousedown keyup",".spec_name_input",function(event) {
    //console.log(id);
        var _this = $(this);
        var specBlock = _this.closest('.one_spec_select');
        var specNameBlock = _this.closest('.select_spec_name');
        var index = specBlock.attr('data-index');
        // _this.removeAttr("data-value");
        var word = specNameBlock.find(".spec_name_input").val().replace(/(^\s*)|(\s*$)/g, "");
        var brand_id = $('#goods-brand_id').val();
        if(event.which == 13)
        {
            event.preventDefault();
            console.log(index,word,brand_id,specNameBlock);
            addSpec(index,word,brand_id,specNameBlock);
        }else
        {
            $.get("/goods/specification/get-specification", {name:word,brand_id:brand_id}, function(data){
                var _data = $.parseJSON(data);
                var html = '';
                if($.isEmptyObject(_data))
                {
                    html = '<a class="list-group-item"  style="border-radius:0;" >搜索无结果</a>'
                }else{
                    $.each(_data,function (index,item) {
                        html += '<a class="list-group-item"  style="border-radius:0;" data-id="'+item.id+'" data-name="'+item.name+'">'+item.name+'</a>';
                    });
                }
                specNameBlock.find(".result_list .list-group").html(html);
                specNameBlock.find(".result_list").show();
            });
        }
    });
    //判断是否是已存在的规格
    function isExistSpecName(specName) {
        //判断全局数组是否已经存在此规格
        for(var i = 0; i < globalSpecInfo.length; i++)
        {
            if(globalSpecInfo[i].name == specName)
            {
                alertMsg(false,'此规格已经添加，请勿重复添加');
                return true;
            }
        }
        return false;
    }
    //点击选择的规格名称
    $('body').on("click",".select_spec_name .list-group-item",function() {
        var _this = $(this);
        var specBlock = _this.closest('.one_spec_select');
        var index = specBlock.data('index');
        var specNameBlock = _this.closest('.select_spec_name');
        var specName = _this.data('name');
        var specId = _this.data('id');
        var brand_id = $('#goods-brand_id').val();
        if(isExistSpecName(specName)) return;
        //保存在全局数组        
        console.log(index,specName,brand_id,specNameBlock);
        addSpec(index,specName,brand_id,specNameBlock);
    })
    //点击加号 添加规格值
    $('body').on('click',".create-event-label",function() {
        var _this = $(this);
        var specBlock = _this.closest('.one_spec_select');
        // alertMsg(false,specBlock.find('.spec_name_input').val());
        if(specBlock.find(".spec_name_input").val()==""){
           alertMsg(false,'请输入规格'); return;
        }else{
            specBlock.find(".add_spec_value_input").show();
        }
    });
    //点击输入规格值
    $('body').on('mousedown keyup','.spec_value_input',function() {
        var _this = $(this);
        var specBlock = _this.closest('.one_spec_select');
        var index = specBlock.data('index');
        var specValueBlock = _this.closest('.spec_value_box');
        
        specValueBlock.find(".result_list").show();
        //获取当前规格的id
        console.log(index);
        var specId = globalSpecInfo[index]['id'];
        console.log(globalSpecInfo);
        var word = _this.val();
        //请求接口
        //请求接口
        if(event.which == 13)
        {
            event.preventDefault();
            addSpecDetail(index,word,specId,specValueBlock);
        }else
        {
            $.get("/goods/specification-detail/get-specification-detail", {name:word,specification_id:specId}, function(data,status){
                console.log(data);
                var _data = $.parseJSON(data);
                var html = '';
                if($.isEmptyObject(_data))
                {
                    html = '<a class="list-group-item"  style="border-radius:0;" >搜索无结果</a>'
                }else{
                    $.each(_data,function (index,item) {
                        html += '<a class="list-group-item"  style="border-radius:0;" data-specid= "'+specId+'"  data-id="'+item.id+'"  data-value="'+item.name+'">'+item.name+'</a>';
                    });
                }
                console.log(html);
                specValueBlock.find(".result_list .list-group").html(html);
            });
        }
    });
    
    //判断是否已经存在此规格值
    function isExistSpecValue(index,specId, specValueId){
        console.log(globalSpecInfo,index,specId, specValueId);
        for(var i = 0; i < globalSpecInfo.length; i++)
        {
            if(globalSpecInfo[i].id == specId)
            {
               for (var j = 0; j < globalSpecInfo[index]['values'].length; j++)
                {
                    if (globalSpecInfo[index]['values'][j] && globalSpecInfo[index]['values'][j]['id'] == specValueId)
                    {
                        alertMsg(false,'此规格值已经添加，请勿重复添加');
                        return true;
                    }
                }
            }
        }
        
        return false;
    }
            //点击选择的规格值
    $('body').on("click",".spec_value_box .list-group-item",function() {
        var _this = $(this);
        var specBlock = _this.closest('.one_spec_select');
        var index = specBlock.data('index');
        var specValueBlock = _this.closest('.spec_value_box');
        var specId = _this.data('specid');
        
        var specValue = _this.data('value');
        var specValueId = _this.data('id');
        console.log(specValueId,specId);
        
        if(isExistSpecValue(index,specId,specValueId)) return;
        
        // console.log(globalSpecInfo,globalSpecInfo.length);
        
        specValueBlock.find(".spec_value_input").val(specValue);
        specValueBlock.find(".spec_value_input").attr("data-value",specValue);
        specValueBlock.find(".spec_value_input").attr("data-specid",specId);
        specValueBlock.find(".spec_value_input").attr("data-id",specValueId);
        specValueBlock.find(".result_list").hide();
    });
    //点击确定 添加属性值
    $('body').on('click','.spec_value_box .confirm_input',function() {
        var _this = $(this);
        var specBlock = _this.closest('.one_spec_select');
        var index = specBlock.attr('data-index');
        var specValueBlock = _this.closest('.spec_value_box');
        var value = specValueBlock.find(".spec_value_input").val();
        var valueId = specValueBlock.find(".spec_value_input").attr("data-id");
        var specId = specBlock.find(".spec_name_input").attr("data-value");//规格id
        if(value == '')
        {
            alertMsg(false,'请输入或选择规格值');
            return;
        }
        var word = specValueBlock.find(".spec_value_input").val();
        addSpecDetail(index,word,specId,specValueBlock);
       
    });
    
    function addSpec(index,word,brand_id,specNameBlock) {
         $.post("/goods/specification/add-specification",{name:word,brand_id:brand_id},function(data) {
                var _data = $.parseJSON(data);
                var html = '';
                if($.isEmptyObject(_data))
                {
                    alertMsg(false,'添加新规格失败');
                }else{
                   alertMsg(true,'添加新规格成功');
                   html += '<a class="list-group-item"  style="border-radius:0;" data-id="'+_data.id+'" data-name="'+_data.name+'">'+_data.name+'</a>';
                }
                specNameBlock.find(".result_list .list-group").html(html);
                globalSpecInfo[index] = {id:_data.id,name:_data.name,values:[]};
                console.log(globalSpecInfo,globalSpecInfo.length);
        
                specNameBlock.find(".spec_name_input").val(_data.name);
                specNameBlock.find(".spec_name_input").attr("data-value",_data.id);
                specNameBlock.find(".result_list").hide();
            })
     }
     
    function addSpecDetail(index,word, specId,specValueBlock) {
        $.post("/goods/specification-detail/add-spec-detail",{value:word,id:specId},function(data) {
                var _data = $.parseJSON(data);
                var html = '';
                if($.isEmptyObject(_data))
                {
                    alertMsg(false,'添加新规格值失败');
                }else{
                   alertMsg(true,'添加新规格值成功');
                   html += '<a class="list-group-item"  style="border-radius:0;" data-specid="'+specId+'"  data-id="'+_data.id+'" data-value="'+_data.value+'">'+_data.value+'</a>';
                }
                specValueBlock.find(".result_list .list-group").html(html);
                var valueId = _data.id;
                var value = _data.value;
                if(isExistSpecValue(parseInt(index),parseInt(specId), parseInt(valueId))) return;
                //保存在全局数组
                globalSpecInfo[index]['values'].push({id:valueId,value:value});
                renderProductTable();
                var html ='<div class="spec_value_tag">' +
                 ' <button type="button" class="spec-close-value" >×</button> ' +
                   '<span class="spec_value_span" data-index="'+index+'" ' +
                   'data-id="' + valueId + '"'+
                   'data-specid="' + specId + '"'+
                   'data-value="'+value+'">'+value+'</span> ' +
                   '</div>';
                specValueBlock.find(".add_spec_value_input").before(html);
                specValueBlock.find(".spec_value_input").attr("data-value",'');
                specValueBlock.find(".spec_value_input").attr("data-specid",'');
                specValueBlock.find(".spec_value_input").attr("data-id",'');
                specValueBlock.find(".spec_value_input").val('');
                specValueBlock.find('.add_spec_value_input').hide();
            });
    }
    //点击X号 删除规格值
    $('body').on('click','.spec-close-value',function() {
        var _this = $(this);
        var thisInputBlock = _this.closest('.one_spec_select');
        _this.closest('.spec_value_tag').remove();
        if(thisInputBlock.find('.spec_value_tag').length == 0)
        {
           thisInputBlock.remove();
        }
        flushGlobalSpecInfo();
        var vid = _this.next().attr('data-id');
        deleteRow(vid);
    });
    function deleteRow(vid) {
        $('.spec_table_box td').each(function() {
            if($(this).attr('data-id') == vid)
            {
                $(this).closest('tr').remove();
            }
        });
        $('.spec_image_hidden_input').each(function() {
            if($(this).attr('data-id') == vid)
            {
                $(this).closest('tr').remove();
            }
        })
    }
    //读取所有已经选择的规格值 刷新全局数组
    function flushGlobalSpecInfo() {
        var specBlock = $('.spec_input');//规格块
        var allInputs = specBlock.find('.one_spec_select');
        console.log(allInputs);
        globalSpecInfo = [];
        //循环每个规格块
        allInputs.each(function(key,input) {
            var specName = $(this).find('.spec_name_input').val();
            var specId = $(this).find('.spec_name_input').attr('data-value');
            var specValues = $(this).find('.spec_value_span');
            globalSpecInfo[key] = {id:specId,name:specName,values:[]};
            //循环规格块中的规格值
            specValues.each(function(index,value) {
                // console.log($(this).attr('data-index'),$(this).attr('data-id'),$(this).attr('data-value'),$(this).attr('data-specid'),key);
                globalSpecInfo[key]['values'].push({id:$(this).attr('data-id'),value:$(this).attr('data-value')})
            })
        });
    }
    //渲染货品列表
    function renderProductTable() {
        var tableHeader = '<thead id="spec_table_thead_id"><tr valign="middle">';
        for (var i = 0; i < globalSpecInfo.length; i++) {
            tableHeader += '<th>' + globalSpecInfo[i].name + '</th>';
        }
        tableHeader += "<th>货号</th><th>条形码</th><th>状态</th></tr></thead>";
        //重点开始
        var z = 1;
        var total = 1;
        //total 算出的表格的行数
        for (var i = 0; i < globalSpecInfo.length; i++) {
            total *= globalSpecInfo[i].values.length;
        }
        //初始化trs 每个tr 是一个空数组(用来存td)
        var trs = [];
        for (var i = 0; i < total; i++) {
            trs.push([]);
        }
        for (var j = globalSpecInfo.length - 1; j >= 0; j--) {
            var v = globalSpecInfo[j]['values'].length;
            for (var i = 0; i < total; i++) {
                var y = Math.floor(i / z) % v;
                trs[i].unshift(globalSpecInfo[j]['values'][y]);
            }
            z *= v;
        }
        //重点结束
        var tbody = '<tbody id="spec_table_tbody_id">';
        for (var i = 0; i < trs.length; i++) //遍历每一行
        {
            var tr = '';
            var specValueIds = [];
            var specValues = [];
            var specInfo = [];
            var firstSpecId;
            for (var j = 0; j < trs[i].length; j++) {
                if(j == 0) {firstSpecId = trs[i][j]['id'];}
                specInfo.push(trs[i][j]);
                specValueIds.push(trs[i][j]['id']);
                specValues.push(trs[i][j]['value']);
                tr += '<td data-id="'+trs[i][j]['id']+'">' + trs[i][j]['value'] + '</td>';
            }
            // specInfo.sort(function(a,b) {return a.id-b.id;});
            specValueIds = specInfo.map(function(a){return a.id;});
            specValues = specInfo.map(function(a) {return a.value;});
            tbody += '<tr>' + tr + 
            '<input name="product['+i+'][firstSpecInfo]" value="'+firstSpecId+'" type="hidden">' +
            '<input name="product['+i+'][specInfo]" value="'+specValueIds.toString()+'|'+specValues.join(' ')+'" type="hidden">' +
            '<td class="product_bn_td"> <input maxlength="20" name="product['+i+'][product_bn]" class="tbody-form-control _product_bn form-control"  style="max-width:180px;"></td>' +
            '<td class="bar_code_td"> <input maxlength="20" name="product['+i+'][bar_code]" class="tbody-form-control form-control"  style="max-width:180px;"></td>' +
            '<td class="status_td"> <select name="product['+i+'][status]"> <option value="0">禁用</option> <option value="1" selected="selected">启用</option></select></td>' +
            '</tr>';
        }
        tbody += '</tbody>';
        var table = '<table id="spec_table" class="table table-bordered no-footer" style="margin-top: 20px; display: table;">' + tableHeader + tbody + '</table>';
        $('.spec_table_box').html(table);
        randerUploadFileTable();
    }
   function randerUploadFileTable() {
        var firstSpec;
        for(var i = 0; i<globalSpecInfo.length;i++)
        {
            if(globalSpecInfo[i] != undefined)
            {
                firstSpec = globalSpecInfo[i];
                break;
            }
        }
        if(firstSpec != undefined)
        {
            var html;
            for(var j = 0; j<firstSpec['values'].length;j++ )
            {
                html += '<tr class="">' +
                            '<td style="text-align: right;font-size: 14px;" class="spec_name_input_1_value_text_1">'+firstSpec['values'][j]['value']+'</td>' +
                            '<td>' +
                                '<div class="uploading-btn-box-1 uploading-btn-box">' +
                                    '<div class="uploading-btn-default">选择要上传的图片</div>' +
                                    '<i class="am-icon-cloud-upload"></i>' +
                                    '<input type="file"  name="norms-imgfile" class="uploading-select-btn""><span style="color:red;"></span>' +
                                    '<input type="hidden" class="spec_image_hidden_input" data-id="'+firstSpec['values'][j]['id']+'" name="specImage['+firstSpec['values'][j]['id']+']" value="">' +

                                '</div>' +
                                '<div class="uploading-show-warp-img-1 uploading-show-warp-img clearfix" style="display: none">' +
                                    '<div class="uploading-show-img uploading-show-img-1">' +
                                    '<img src="../../statics/goods/images/600_400.png" class="spec_norms_imgs" data-id="1">' +
                                    '<button type="button" class="spec-remove" style="">×</button>' +
                                    '</div>' +
                                    '<div class="uploading-show-text uploading-show-text-1">' +
                                        '<p class="info-tips"><em class="required">*</em>1、商品规格仅限 1 张图片；</p>' +
                                        '<p class="info-tips info-tips-10">2、本地上传图片大小不能超过200KB；</p>' +
                                        '<p class="info-tips info-tips-10">3、商品规格图尺寸比例1:1；</p>' + 
                                    '</div>' + 
                                '</div>' +
                            '</td>' + 
                        '</tr>';
            }
            $('#spec_norms_table_tbody_id').html(html);
            $('.spec_table_norms_box').show();
        }     
   }
    $('body').on('click','.add_spec_btn', function() {
        var spec_tpl = $('#spec_tpl').html();
        var new_index = globalSpecInfo.length;
        var html = '<div class="one_spec_select clearfix" data-index="'+new_index+'">' + spec_tpl + '</div>';
        $('.spec_input').append(html);
    })
    $('body').on('click','.clear_diyinput_value',function() {
        var _this = $(this);
        var specBlock = _this.closest('.spec_input');        
        var inputBlock = _this.closest('.one_spec_select');
        var input = inputBlock.find('.spec_name_input');
        input.attr('data-value','');
        input.val('');
        var tagCloseBtns = inputBlock.find('.spec-close-value');
        tagCloseBtns.each(function(k,v) {
            $(this).click();
        })
     });
    $('body').on('change','input[name=norms-imgfile]',function (event){
        var _this = $(this);
        var thisTd = _this.closest('td');
        var files = event.target.files;
                console.log(files);
        var _this = $(this);
        // var prevImg = _this.prev().find('img');
        // console.log(prevImg);
        var data = new FormData();
        if(files[0] === undefined)
        {
            return;
        }else{ //检查图片格式
            var imageType = /image.*/;
            console.log(files[0]);
            if(!(files[0].type.match(imageType)))
            {
                alertMsg(false,'请选择图片文件');
                return;
            }
        }
        //设置预览
        var reader = new FileReader();
        reader.readAsDataURL(files[0]);

        // reader.onload = function(e) {
        //     prevImg.attr('src',e.target.result);
        // }
        
        data.append("UploadImgForm[img]", files[0]);
        var hiddenInput = _this.next().next();
        $.ajax({
            url: '{$upload_img_url}',
            type: 'POST',
            data: data,
            cache: false,
            dataType: 'json',
            processData: false, // Don't process the files
            contentType: false, // Set content type to false as jQuery will tell the server its a query string request
            success: function(data, textStatus, jqXHR)
            {
                if(data.status === 'succ')
                {
                    thisTd.find('.uploading-btn-box').hide();
                    thisTd.find('.spec_norms_imgs').attr('src',data.imgUrl);
                    thisTd.find('.uploading-show-warp-img').show();
                    hiddenInput.val(data.imgUrl);
                    var valueId = hiddenInput.attr('data-id');
                    
                    alertMsg(true,'上传成功');
                }else{
                    alertMsg(false,'上传失败');
                }
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
            }
        }); 
    });
    $('body').on('click','.spec-remove',function(){
        var _this = $(this);
        var thisTd = _this.closest('td');
        thisTd.find('.spec_image_hidden_input').val('');
        thisTd.find('.norms-imgfile').val('');
        thisTd.find('.spec_norms_imgs').attr('src','../../statics/goods/images/600_400.png');
        thisTd.find('.uploading-show-warp-img').hide();
        thisTd.find('.uploading-btn-box').show();
    });
    //上传轮播图
    $('body').on('change','.upload_img_banner',function (event){
        var _this = $(this);
        var thisDiv = _this.closest('div');
        var files = event.target.files;
                console.log(files);
        var _this = $(this);
        // var prevImg = _this.prev().find('img');
        // console.log(prevImg);
        var data = new FormData();
        if(files[0] === undefined)
        {
            return;
        }else{ //检查图片格式
            var imageType = /image.*/;
            console.log(files[0]);
            if(!(files[0].type.match(imageType)))
            {
                alertMsg(false,'请选择图片文件');
                return;
            }
        }
        //设置预览
        var reader = new FileReader();
        reader.readAsDataURL(files[0]);

        // reader.onload = function(e) {
        //     prevImg.attr('src',e.target.result);
        // }
        
        data.append("UploadImgForm[img]", files[0]);
        var hiddenInput = _this.next();
        $.ajax({
            url: '{$upload_img_url}',
            type: 'POST',
            data: data,
            cache: false,
            dataType: 'json',
            processData: false, // Don't process the files
            contentType: false, // Set content type to false as jQuery will tell the server its a query string request
            success: function(data, textStatus, jqXHR)
            {
                if(data.status === 'succ')
                {
                    thisDiv.find('.thumbnail').attr('src',data.imgUrl);
                    hiddenInput.val(data.imgUrl);
                    alertMsg(true,'上传成功');
                }else{
                    alertMsg(false,'上传失败');
                }
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
            }
        }); 
    });
    $('body').on('click','.del_img',function(){
        var _this = $(this);
        var thisDiv = _this.closest('div');
        thisDiv.find('.thumbnail').attr('src','../../statics/goods/images/600_400.png');
        thisDiv.find('.upload_img_banner').val('');
        thisDiv.find('.upload_img_banner_hidden').val('');
    });
    $('body').on('change','.last-uploading-img',function(){
        var _this = $(this);
        var mobileWind = $('body').find('.window-last-upload');
        var mobileImgList = $('body').find('.mobile-img-list');
        
        var files = event.target.files;
        // var prevImg = _this.prev().find('img');
        // console.log(prevImg);
        var data = new FormData();
        if(files[0] === undefined)
        {
            return;
        }else{ //检查图片格式
            var imageType = /image.*/;
            console.log(files[0]);
            if(!(files[0].type.match(imageType)))
            {
                alertMsg(false,'请选择图片文件');
                return;
            }
        }
        //设置预览
        var reader = new FileReader();
        reader.readAsDataURL(files[0]);
        
        data.append("UploadImgForm[img]", files[0]);
        var hiddenInput = _this.next();
        $.ajax({
            url: '{$upload_img_url}',
            type: 'POST',
            data: data,
            cache: false,
            dataType: 'json',
            processData: false, // Don't process the files
            contentType: false, // Set content type to false as jQuery will tell the server its a query string request
            success: function(data, textStatus, jqXHR)
            {
                if(data.status === 'succ')
                {
                    mobileWind.append('<p class="del_last_img_index"><img  name="del_last_img_index[]"  src="'+data.imgUrl+'" ></p>');
                    mobileImgList.append('<li class="del_last_img_index"><img src="'+data.imgUrl+'"><input type="hidden" name="goodsDetailImg[]" value="'+data.imgUrl+'|'+data.width+'|'+data.height+'"><span class="del_img last_del_img close-modal">×</span></li>');
                    // thisDiv.find('.thumbnail').attr('src',data.imgUrl);
                    // hiddenInput.val(data.imgUrl);
                    alertMsg(true,'上传成功');
                }else{
                    alertMsg(false,'上传失败');
                }
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
            }
        });         
    });
    //详情图删除
    $('body').on('click','.del_last_img_index',function(){
        var _this = $(this);
        var mobileWind = $('body').find('.window-last-upload');
        var thisLi = _this.closest('li');
        var imgUrl = thisLi.find('img').attr('src');
        thisLi.remove();
        var imgs = mobileWind.find('img');
        imgs.each(function(){
            if($(this).attr('src') == imgUrl){
                $(this).closest('p').remove();
            }
        });
    })
    
})
JS;
$this->registerJs($js);
?>
