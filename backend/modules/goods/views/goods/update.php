<?php

use backend\assets\GodGoodsAsset;
use backend\libraries\CategoryLib;
use backend\libraries\GoodsChannelLib;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use backend\assets\FlowPathAsset;

GodGoodsAsset::register($this);

$this->title = '更新商品';
$this->params['breadcrumbs'][] = ['label' => '商品列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div style="max-width: 1200px;height: auto;margin: 0 auto;background: #ffffff;border: 1px solid #d8d8d8;">
    <!-- hidden begin -->

    <?php $form = ActiveForm::begin([
        'id' => 'goods_update_form',
        'options' => [
            'enctype' => 'multipart/form-data',
            'style'=> 'margin:30px 30px;'
        ],

    ]); ?>
    <!--开始内容-->
    <div class="norms-warp" style="display: block">
        <div class="body-head">
            <span class="body-title">编辑规格和规格值</span>
        </div>
        <div class="product-form">
            <div class="form-group">
                <div class="spec_input" data-index="1" style="">
                    <div class="one_spec_select one_spec_select_1 clearfix">
                        <div class="select_spec_name">
                            <div class="result_list result_list_1">
                                <div class="list-group" style="overflow-x: hidden;overflow-y: auto;max-height:200px;border-bottom: 1px solid #ddd;margin-bottom:0px">
                                    <a class="list-group-item" style="border-radius:0;" data-id="" data-name="">查询中...</a>
                                </div>
                                <button class="spec-remove" style="" type="button" onclick="CloseResultList(1)">×</button>
                            </div>
                            <div class="spec_name_box">
                                <input type="text" name="spec_name_input_1[]" class="spec_name_input_1 form-control inline spec_name_input inline" data-value="<?php echo $model->classify_id ?>" data-showId="1" readonly="readonly"  value="<?php echo $model->classify_name ?>" >
                            </div>
                        </div>
                        <div class="spec_value_box spec_value_box_1" >
                            <p style="width: 492px;padding-top: 10px;margin-left: 15px;">选项列表</p>
                            <div class="add_spec_value clearfix">
                                <?php
                                if(is_array($model->classify_details)){
                                    foreach ($model->classify_details as $key=>$classify_detail)
                                    {
                                        $k=$key+1;
                                        $classify_detail_id = $classify_detail['classify_detail_id'];
                                        $classify_detail_name = $classify_detail['classify_detail_name'];
                                        echo "<div class='spec_value_tag_1_$k spec_value_tag'> <button type='button' class='spec-close-value' onclick='removeEventFormItemValue(1,".$k.")'>×</button> <span class='spec_value_span_1_$k' data-index='1_$k' data-value=$classify_detail_id> $classify_detail_name</span> </div>";
                                    }
                                }
                                ?>
                                <div class="add_spec_value_input add_spec_value_input_1" style="display: none">
                                    <div class="spec_name_box">
                                        <input type="text" class="spec_name_value_input_1 form-control inline spec_name_input"  placeholder="输入规格值检索或新建" onmousedown="LoadItemTagWord(1)" onkeyup="LoadItemTagWord(1)">
                                        <i class="fa fa-fw fa-times clear_diyinput_value" onclick="removeAddFormItemVlaue(1)"></i>
                                        <div class="result_list result_tag_list_1">
                                            <div class="list-group" style="overflow-x: hidden;overflow-y: auto;max-height:200px;border-bottom: 1px solid #ddd;margin-bottom:0px">
                                                <a class="list-group-item" style="border-radius:0;" data-id="" data-name="">查询中...</a>
                                            </div>
                                            <button class="spec-remove" style=""  type="button" onclick="CloseResultTagList(1)">×</button>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary confirm_input confirm_input_1" type="button" data-index="1" onclick="addEventFormItemValue(1)" style="margin-left: 5px;">确定</button>
                                    <button class="btn btn-default cancle_value" type="button" onclick="closeEventFormItemValue(1)" style="margin-left:5px;">取消</button>
                                </div>
                                <button class="btn create-event-label" type="button" onclick="addSpecItemValue(1);"><span name="event_form_item_ctrl" class="icon-event-label-add"></span></button>
                            </div>
                        </div>
                    </div>
                    <!--选项-->
                    <div class="one_spec_select one_spec_select_2 clearfix">
                        <div class="select_spec_name">
                            <div class="result_list result_list_2">
                                <div class="list-group" style="overflow-x: hidden;overflow-y: auto;max-height:200px;border-bottom: 1px solid #ddd;margin-bottom:0px">
                                    <a class="list-group-item" style="border-radius:0;" data-id="" data-name="">查询中...</a>
                                </div>
                                <button class="spec-remove"  type="button" style="" onclick="CloseResultList(2)">×</button>
                            </div>
                            <div class="spec_name_box">
                                <input type="text" name="spec_name_input_2[]" class="spec_name_input_2 form-control inline spec_name_input inline" data-value="<?php echo $model->spec_id ?>" data-showId="2" value="<?php echo $model->spec_name ?>" readonly="readonly" />
                            </div>
                        </div>
                        <div class="spec_value_box spec_value_box_2" >
                            <p style="width: 492px;padding-top: 10px;margin-left: 15px;">选项列表</p>
                            <div class="add_spec_value clearfix">
                                <?php
                                if(is_array($model->spec_details)){
                                    foreach ($model->spec_details as $key=>$spec_detail)
                                    {
                                        $k=$key+1;
                                        $spec_detail_id = $spec_detail['spec_detail_id'];
                                        $spec_detail_name = $spec_detail['spec_detail_name'];
                                        echo "<div class='spec_value_tag_2_$k spec_value_tag'> <button type='button' class='spec-close-value' onclick='removeEventFormItemValue(2,$k)'>×</button> <span class='spec_value_span_2_$k' data-index='2_$k' data-value=$spec_detail_id> $spec_detail_name</span> </div>";
                                    }
                                }
                                ?>
                                <div class="add_spec_value_input add_spec_value_input_2" style="display: none">
                                    <div class="spec_name_box">
                                        <input type="text" class="spec_name_value_input_2 form-control inline spec_name_input"  placeholder="输入规格值检索或新建" onmousedown="LoadItemTagWord(2)" onkeyup="LoadItemTagWord(2)">
                                        <i class="fa fa-fw fa-times clear_diyinput_value" onclick="removeAddFormItemVlaue(2)"></i>
                                        <div class="result_list result_tag_list_2">
                                            <div class="list-group" style="overflow-x: hidden;overflow-y: auto;max-height:200px;border-bottom: 1px solid #ddd;margin-bottom:0px">
                                                <a class="list-group-item" style="border-radius:0;" data-id="" data-name="">查询中...</a>
                                            </div>
                                            <button class="spec-remove" type="button" style="" onclick="CloseResultTagList(2)">×</button>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary confirm_input confirm_input_2" type="button" data-index="2" onclick="addEventFormItemValue(2)" style="margin-left: 5px;">确定</button>
                                    <button class="btn btn-default cancle_value" type="button" onclick="closeEventFormItemValue(2)" style="margin-left:5px;">取消</button>
                                </div>
                                <button class="btn create-event-label" type="button" onclick="addSpecItemValue(2);"><span name="event_form_item_ctrl" class="icon-event-label-add"></span></button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <p class="tips" id="set_all_num_tips" style="display: block;"><em>*</em>当市场价≠销售价时，商品价格将显示"销售价&nbsp;&nbsp;<span class="text-line-through">市场价</span>"；当市场价=销售价时，商品价格将只显示销售价。</p>
        <!--表格-->
        <div class="spec_table_box">
            <table id="spec_table" class="table table-bordered no-footer" style="margin-top: 20px; display: table;">
                <thead id="spec_table_thead_id">
                <?php if($model->classify_name||$model->spec_name){ ?>
                    <tr valign="middle">
                        <th><?php echo $model->classify_name ?></th>
                        <th><?php echo $model->spec_name ?></th>
                        <th >货号</th>
                        <th >条形码</th>
                        <th >状态</th>
                    </tr>
                <?php } ?>
                </thead>
                <tbody id="spec_table_tbody_id">
                <?php
                if(is_array($model->products)){
                    foreach ($model->products as $key=>$product)
                    {
                        ?>
                        <tr class="spec_table_tbody_tr_<?php echo $key?>" data-index="<?php echo $key?>">
                            <td ><span class="tbody-form-text tbody-form-text-text-<?php echo $key?>"  data-id="<?php echo $product['classify_detail_id']?>"><?php echo $product['classify_detail_name']?></span></td>
                            <td ><span class="tbody-form-text tbody-form-text-name-<?php echo $key?>"   data-id="<?php echo $product['spec_detail_id']?>"><?php echo $product['spec_detail_name']?></span></td>
                            <td class="product_bn_td">
                                <input maxlength="20" name="spec_Numbers" class="spec-numbers-<?php echo $key?> tbody-form-control form-control" data-sku="" data-sku-id="" data-old-code="" style="max-width:180px;" value="<?php echo $product['product_bn']?>">
                            </td>
                            <td class="bar_code_td">
                                <input class="tbody-form-control form-control spec-barcode-<?php echo $key?>" name="spec_barCode" type="text" style="max-width:180px;" maxlength="11" value="<?php echo $product['bar_code']?>">
                            </td>
                            <td class="status_td">
                                <select class="selected-<?php echo $key?>">
                                    <option value="0" >禁用</option>
                                    <option value="1" selected="selected">启用</option>
                                </select>
                            </td>
                        </tr>
                        <?php
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
        <!--/表格-->
        <!--规格图-->
        <div class="spec_table_norms_box" style="display:block">
            <table class="table table-bordered">
                <table id="spec_norms_table" class="table table-bordered no-footer" style="margin-top: 20px; display: table;">
                    <thead id="spec_norms_table_thead_id">
                    <tr valign="middle">
                        <th style="width: 160px;" id="spec_norms_thead_name"><?php echo $model->classify_name ?></th>
                        <th >规格图</th>
                    </tr>
                    </thead>
                    <tbody id="spec_norms_table_tbody_id">
                    <?php
                    foreach ($model->classify_details as $key=>$classify_detail){
                        $key = $key+1;
                        ?>
                        <tr class="">
                            <td style="text-align: right;font-size: 14px;" class="spec_name_input_1_value_text_<?php echo $key ?>"><?php echo $classify_detail['classify_detail_name'] ?></td>
                            <td>
                                <?php if(!$classify_detail['classify_detail_image']){ ?>
                                    <div class="uploading-btn-box-<?php echo $key ?> uploading-btn-box"  style="display:block">
                                        <div class="uploading-btn-default">选择要上传的图片</div>
                                        <i class="am-icon-cloud-upload"></i>
                                        <input type="file" id="imgfile-<?php echo $key ?>"  name="norms-imgfile" class="uploading-select-btn" onchange="selectPicture(<?php echo $key ?>)">
                                    </div>
                                <?php }else{?>
                                    <div class="uploading-btn-box-<?php echo $key ?> uploading-btn-box"  style="display:none">
                                        <div class="uploading-btn-default">选择要上传的图片</div>
                                        <i class="am-icon-cloud-upload"></i>
                                        <input type="file" id="imgfile-<?php echo $key ?>"  name="norms-imgfile" class="uploading-select-btn" onchange="selectPicture(<?php echo $key ?>)">
                                    </div>
                                    <div class="uploading-show-warp-img-<?php echo $key ?> uploading-show-warp-img clearfix" style="display: block">
                                        <div class="uploading-show-img uploading-show-img-<?php echo $key ?>">
                                            <img src="<?php echo $classify_detail['classify_detail_image'] ?>" data-src="<?php echo $classify_detail['classify_detail_image'] ?>" class="spec_norms_imgs" data-id="<?php echo $key ?>">
                                            <button type="button" class="spec-remove" style="" onclick="removeUploadingImg(<?php echo $key ?>)">×</button>
                                        </div>
                                        <div class="uploading-show-text uploading-show-text-<?php echo $key ?>">
                                            <p class="info-tips" ><em class="required">*</em>1、商品规格仅限 1 张图片；</p>
                                            <p class="info-tips info-tips-10">2、本地上传图片大小不能超过200KB；</p>
                                            <p class="info-tips info-tips-10">3、商品规格图尺寸比例1:1；</p>
                                        </div>
                                    </div>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php }?>
                    </tbody>
                </table>
            </table>
        </div>
        <!--/规格图-->
        <!--提交下一步-->
        <div class="product-buttons">
            <button class="btn btn-primary" type="button" onclick="nextStep(3)">下一步</button>
        </div>
    </div>
    <!--开始内容-->
    <!--主图详情图-->
    <div class="banner-warp" style="display: none">
        <div class="body-head">
            <span class="body-title">编辑商品海报图</span>
        </div>
        <div class="pro-abs-div" style="margin-top: 10px;">
            <p class="abs-info-tip"><em class="required" style="margin-right: 2px; margin-left: 0;">*</em> 1、图片比例1:1，建议尺寸800px*800px，本地上传图片大小不能超过500KB;</p>
            <p class="abs-info-tip info-tips-10">2、商品海报图为商品/活动详情页轮播图，最多可上传6张；</p>
        </div>
        <div class="slide-imgs">
            <?php
            for($key=1;$key<=6;$key++){
                $img =isset($model->goods_navigates[$key])?$model->goods_navigates[$key]:'../../statics/img/600_400.png';
                $data_img =isset($model->goods_navigates[$key])?$model->goods_navigates[$key]:'';

                ?>
                <div class="img-item">
                    <div class="change_img_div act_img_div">
                        <span class="change_img_btn"><i class="fa fa-chain"></i></span>
                        <span class="del_img close-modal" id="del_img_<?php echo $key?>" onclick="del_img(<?php echo $key?>)">×</span>
                        <img src="<?php echo $img ?>" data-src="<?php echo $data_img ?>" class="thumbnail" name="post_photo_pre<?php echo $key?>" id="post_photo_pre<?php echo $key?>">
                        <input type="file" class="upload_img_banner" name="upload_img" id="upload_img_<?php echo $key?>" onchange="uploadBannerImg(<?php echo $key?>)">
                    </div>
                </div>
                <?php
            } ?>
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
                            if(is_array($model->goods_details)){
                                foreach ($model->goods_details as $key=>$goods_detail)
                                {
                                    ?>
                                    <p class="del_last_img_index_<?php echo $key ?>"><img  name="del_last_img_index[]"  src="<?php echo $goods_detail ?>" data-src="<?php echo $goods_detail ?>"></p>
                                <?php }}?>
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
                        <img src="../../statics/img/last-last-upload-img.png" >
                        <input type="file" class="last-uploading-img" id="last-uploading-img" onchange="lastUploading()">
                    </div>
                </div>
                <ul class="last-items-img clearfix">
                    <?php
                    if(is_array($model->goods_details)){
                        foreach ($model->goods_details as $key=>$goods_detail)
                        {
                            ?>
                            <li class="del_last_img_index_<?php echo $key ?>"><img src="<?php echo $goods_detail ?>"><span class="del_img close-modal" onclick="del_last_img(<?php echo $key ?>)">×</span></li>
                        <?php }}?>
                </ul>
            </div>
        </div>
        <!--banne图、详情图提交-->
        <div class="product-buttons">
            <button class="btn btn-primary" type="button" onclick="nextStep(2)">上一步</button>
            <button id="goods-update-button" class="btn btn-primary" type="button" onclick="submitUpdateForm()">确认提交</button>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
    <!--商品ID-->
    <input type="hidden" id="goodsId" value="<?php echo $goods_id?>">
    <div class="alert alert-danger form-alert-info" style="display: none" role="alert"><strong>提示：</strong>请输入规格</div>
    <div class="alert alert-danger form-alert-info-value" style="display: none" role="alert"><strong>提示：</strong> 请输入规格值</div>
    <!-- /form end -->
</div>

<script id="goods-img-template" type="text/x-handlebars-template">
    {{#each data}}
    <tr class="">
        <td style="text-align: right;font-size: 14px;" class="spec_name_input_1_value_text_{{id}}">{{text}}</td>
        <td>
            <div class="uploading-btn-box-{{id}} uploading-btn-box" >
                <div class="uploading-btn-default">选择要上传的图片</div>
                <i class="am-icon-cloud-upload"></i>
                <input type="file" id="imgfile-{{id}}"  name="norms-imgfile" class="uploading-select-btn" onchange="selectPicture({{id}})">
            </div>
            <div class="uploading-show-warp-img-{{id}} uploading-show-warp-img clearfix" style="display: none">
                <div class="uploading-show-img uploading-show-img-{{id}}">
                    <img src="../../statics/img/600_400.png" class="spec_norms_imgs" data-id="{{id}}">
                    <button type="button" class="spec-remove" style="" onclick="removeUploadingImg({{id}})">×</button>
                </div>
                <div class="uploading-show-text uploading-show-text-{{id}}">
                    <p class="info-tips" ><em class="required">*</em>1、商品规格仅限 1 张图片；</p>
                    <p class="info-tips info-tips-10">2、本地上传图片大小不能超过200KB；</p>
                    <p class="info-tips info-tips-10">3、商品规格图尺寸比例1:1；</p>
                </div>
            </div>
        </td>
    </tr>
    {{/each}}
</script>
<script id="thead-template" type="text/x-handlebars-template">
    <tr valign="middle">
        {{#each thead}}
        <th>{{theadName}}</th>
        {{/each}}
        <th >货号</th>
        <th >条形码</th>
        <th >状态</th>
    </tr>
</script>
<script id="tbody-tr-template-1" type="text/x-handlebars-template">
    {{#each data}}
    <tr class="spec_table_tbody_tr_{{index}}">
        <td ><span class="tbody-form-text" data-id="{{id}}">{{text}}</span></td>
        <td class="product_bn_td">
            <input  maxlength="20"  name="spec_Numbers" class="tbody-form-control form-control" data-sku="" data-sku-id="" data-old-code="" style="max-width:180px;">
        </td>
        <td class="bar_code_td">
            <input class="tbody-form-control form-control" name="spec_barCode" type="text" style="max-width:180px;" maxlength="11">
        </td>
        <td class="status_td">
            <select>
                <option value="0">禁用</option>
                <option value="1" selected="selected">启用</option>
            </select>
        </td>
    </tr>
    {{/each}}
</script>
<script id="tbody-tr-template-2" type="text/x-handlebars-template">
    {{#each data}}
    <tr class="spec_table_tbody_tr_{{index}}" data-index="{{index}}">
        <td ><span class="tbody-form-text tbody-form-text-text-{{index}}"  data-id="{{id}}">{{text}}</span></td>
        <td ><span class="tbody-form-text tbody-form-text-name-{{index}}"   data-id="{{value}}">{{name}}</span></td>
        <td class="product_bn_td">
            <input maxlength="20" name="spec_Numbers" class="spec-numbers-{{index}} tbody-form-control form-control" data-sku="" data-sku-id="" data-old-code="" style="max-width:180px;" >
        </td>
        <td class="bar_code_td">
            <input class="tbody-form-control form-control spec-barcode-{{index}}" name="spec_barCode" type="text" style="max-width:180px;" maxlength="11">
        </td>
        <td class="status_td">
            <select class="selected-{{index}}">
                <option value="0">禁用</option>
                <option value="1" selected="selected">启用</option>
            </select>
        </td>
    </tr>
    {{/each}}
</script>