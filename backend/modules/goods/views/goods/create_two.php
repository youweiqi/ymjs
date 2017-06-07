<?php

use backend\assets\GoodsAsset;
use backend\libraries\CategoryLib;
use backend\libraries\GoodsChannelLib;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use backend\assets\FlowPathAsset;

GoodsAsset::register($this);

$this->title = '新增商品';
$this->params['breadcrumbs'][] = ['label' => '商品列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div style="max-width: 1200px;height: auto;margin: 0 auto;background: #ffffff;border: 1px solid #d8d8d8;">
    <input type="hidden" id="goods_brand_id" value="<?php echo $brand_id ?>"/>
    <!-- hidden begin -->
    <form id="goodsform" action="#" name="goodsform"  enctype="multipart/form-data"  method="post" style="margin:30px 30px" onsubmit="return false">
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
                                    <input type="text" name="spec_name_input_1[]" class="spec_name_input_1 form-control inline spec_name_input inline" data-value="" data-showId="1"  placeholder="输入规格检索或新建"  onmousedown="LoadItemWord(1)" onkeyup="LoadItemWord(1)" onblur="blurFromItemValue(1)">
                                    <i class="fa fa-fw fa-times clear_diyinput_value" onclick="removeEventFormItemVlaue(1)"></i>
                                </div>
                            </div>
                            <div class="spec_value_box spec_value_box_1" >
                                <p style="width: 492px;padding-top: 10px;margin-left: 15px;">选项列表</p>
                                <div class="add_spec_value clearfix">
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
                                    <input type="text" name="spec_name_input_2[]" class="spec_name_input_2 form-control inline spec_name_input inline" data-showId="2"  placeholder="输入规格检索或新建" onmousedown="LoadItemWord(2)" onkeyup="LoadItemWord(2)" onblur="blurFromItemValue(2)">
                                    <i class="fa fa-fw fa-times clear_diyinput_value" onclick="removeEventFormItemVlaue(2)"></i>
                                </div>
                            </div>
                            <div class="spec_value_box spec_value_box_2" >
                                <p style="width: 492px;padding-top: 10px;margin-left: 15px;">选项列表</p>
                                <div class="add_spec_value clearfix">
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

                    </thead>
                    <tbody id="spec_table_tbody_id">
                    </tbody>
                </table>
            </div>
            <!--/表格-->
            <!--规格图-->
            <div class="spec_table_norms_box" style="display: none">
                <table class="table table-bordered">
                    <table id="spec_norms_table" class="table table-bordered no-footer" style="margin-top: 20px; display: table;">
                        <thead id="spec_norms_table_thead_id">
                        <tr valign="middle">
                            <th style="width: 160px;" id="spec_norms_thead_name"></th>
                            <th >规格图</th>
                        </tr>
                        </thead>
                        <tbody id="spec_norms_table_tbody_id">

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
                <div class="img-item">
                    <div class="change_img_div act_img_div">
                        <span class="change_img_btn"><i class="fa fa-chain"></i></span>
                        <img src="../../statics/goods/images/600_400.png" class="thumbnail" name="post_photo_pre1" id="post_photo_pre1">
                        <input type="file" class="upload_img_banner" name="upload_img" id="upload_img_1" onchange="uploadBannerImg(1)">
                    </div>
                </div>
                <div class="img-item">
                    <div class="change_img_div act_img_div">
                        <span class="change_img_btn"  ><i class="fa fa-chain"></i></span>
                        <span class="del_img close-modal" id="del_img_2" onclick="del_img(2)">×</span>
                        <img src="../../statics/goods/images/600_400.png" name="post_photo_pre2"  class="thumbnail thumbnail-2" id="post_photo_pre2">
                        <input type="file" class="upload_img_banner" name="upload_img" id="upload_img_2" onchange="uploadBannerImg(2)">
                    </div>
                </div>
                <div class="img-item">
                    <div class="change_img_div act_img_div">
                        <span class="change_img_btn"  ><i class="fa fa-chain"></i></span>
                        <span class="del_img close-modal" id="del_img_3" onclick="del_img(3)">×</span>
                        <img src="../../statics/goods/images/600_400.png" name="post_photo_pre3" class="thumbnail thumbnail-3" id="post_photo_pre3">
                        <input type="file" class="upload_img_banner" name="upload_img" id="upload_img_3" onchange="uploadBannerImg(3)">
                    </div>
                </div>
                <div class="img-item">
                    <div class="change_img_div act_img_div">
                        <span class="change_img_btn"  ><i class="fa fa-chain"></i></span>
                        <span class="del_img close-modal" id="del_img_4" onclick="del_img(4)">×</span>
                        <img src="../../statics/goods/images/600_400.png" name="post_photo_pre4"  class="thumbnail thumbnail-4" id="post_photo_pre4">
                        <input type="file" class="upload_img_banner" name="upload_img" id="upload_img_4" onchange="uploadBannerImg(4)">
                    </div>
                </div>
                <div class="img-item">
                    <div class="change_img_div act_img_div">
                        <span class="change_img_btn"  ><i class="fa fa-chain"></i></span>
                        <span class="del_img close-modal" id="del_img_5" onclick="del_img(5)">×</span>
                        <img src="../../statics/goods/images/600_400.png" name="post_photo_pre5"  class="thumbnail thumbnail-5" id="post_photo_pre5">
                        <input type="file" class="upload_img_banner" name="upload_img" id="upload_img_5" onchange="uploadBannerImg(5)">
                    </div>
                </div>
                <div class="img-item">
                    <div class="change_img_div act_img_div">
                        <span class="change_img_btn"  ><i class="fa fa-chain"></i></span>
                        <span class="del_img close-modal" id="del_img_6" onclick="del_img(6)">×</span>
                        <img src="../../statics/goods/images/600_400.png" name="post_photo_pre6"  class="thumbnail thumbnail-6" id="post_photo_pre6">
                        <input type="file" class="upload_img_banner" name="upload_img" id="upload_img_6" onchange="uploadBannerImg(6)">
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
                            <div class="window-last-upload"></div>
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
                            <input type="file" class="last-uploading-img" id="last-uploading-img" onchange="lastUploading()">
                        </div>
                    </div>
                    <ul class="last-items-img clearfix"></ul>
                </div>
            </div>
            <!--banne图、详情图提交-->
            <div class="product-buttons">
                <button class="btn btn-primary" type="button" onclick="nextStep(2)">上一步</button>
                <button id="goods-create-button" class="btn btn-primary" type="button" onclick="submitForm()">确认提交</button>
            </div>
        </div>
    </form>
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
                    <img src="../../statics/goods/images/600_400.png" class="spec_norms_imgs" data-id="{{id}}">
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
            <input maxlength="20" name="spec_Numbers" class="spec-numbers-{{index}} tbody-form-control form-control" data-sku="" data-sku-id="" data-old-code="" style="max-width:180px;">
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