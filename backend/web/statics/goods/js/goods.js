$(function () {
    
});

//加载规格Form下拉
function  LoadItemWord(id) {
    //console.log(id);
    $(".spec_name_input_"+id+"").removeAttr("data-value");
    if($(".result_list_"+id+"").is(":hidden")) {
        var brand_id = $('#goods_brand_id').val();
        var word = $(".spec_name_input_" + id + "").val().replace(/(^\s*)|(\s*$)/g, "");
        $(".result_list_" + id + "").show();
        //请求接口
        $.get("/goods/specification/get-specification", {name:word}, function(data,status){
            if(data){
                var _data = $.parseJSON(data);
                var html = '';
                $.each(_data,function (index,item) {
                    html += '<a class="list-group-item" onclick="UpdateFromItemValue('+id+',\''+item.name+'\','+item.id+')" style="border-radius:0;" data-value="'+item.id+'" data-name="'+item.name+'">'+item.name+'</a>';
                });
                $(".result_list_"+id+" .list-group").html(html);
            }
        });
    }
}
function CloseResultList(id) {
    $(".result_list_"+id+"").hide();
}
function UpdateFromItemValue(id,name,value) {
    $(".spec_name_input_"+id+"").val(name);
    $(".spec_name_input_"+id+"").attr("data-value",value);
    $(".result_list_"+id+"").hide();
}

function  LoadItemTagWord(id) {
    if($(".result_list_"+id+"").is(":hidden")){
        if($(".result_tag_list_"+id+" .list-group a").length<1){
            $(".result_tag_list_"+id+" .list-group").html('<a class="list-group-item" style="border-radius:0;" data-id="" data-name="">查询中...</a>');
        }
        var word = $(".spec_name_value_input_"+id+"").val().replace(/(^\s*)|(\s*$)/g,"");
        var wordId =$(".spec_name_input_"+id+"").attr("data-value");
        if(!wordId){
            wordId = "";
        }
        //alert(wordId);
        $(".result_tag_list_"+id+"").show();
        //请求接口
        //请求接口
        $.get("/goods/specification-detail/get-specification-detail", {name:word,specification_id:wordId}, function(data,status){
            if(data){
                var _data = $.parseJSON(data);
                if(_data.length>0){
                    var html = '';
                    $.each(_data,function (index,item) {
                        html += '<a class="list-group-item" onclick="UpdateFromItemTagValue('+id+',\''+item.name+'\','+item.id+')" style="border-radius:0;" data-id="'+item.id+'" data-name="'+item.name+'">'+item.name+'</a>';
                    });
                    $(".result_tag_list_"+id+" .list-group").html(html);
                }else{
                    $(".result_tag_list_"+id+" .list-group").html('<p>没有匹配的数据...</p>');
                }

            }
        });
    }
}
function CloseResultTagList(id) {
    $(".result_tag_list_"+id+"").hide();
}
function UpdateFromItemTagValue(id,name,value) {
    $(".spec_name_value_input_"+id+"").val(name);
    $(".spec_name_value_input_"+id+"").attr('data-value',value);
    $(".result_tag_list_"+id+"").hide();
}

function  blurFromItemValue(id) {
    if($(".spec_name_input_"+id+"").val()==""){

    }else{
        var theadName =$(".spec_name_input_"+id+"").val().replace(/(^\s*)|(\s*$)/g,"");
        if(id==1){
            var val1 =$(".spec_name_input_1").val().replace(/(^\s*)|(\s*$)/g,"");
            var val2 = $(".spec_name_input_2").val().replace(/(^\s*)|(\s*$)/g,"");
            if(val1==val2){
                alert("规格名称已存在");
                $(".spec_name_input_"+id+"").val("");
            }else{
                theadData1.splice(0,0,theadName);
            }
        }else{
            var val1 =$(".spec_name_input_1").val().replace(/(^\s*)|(\s*$)/g,"");
            var val2 = $(".spec_name_input_2").val().replace(/(^\s*)|(\s*$)/g,"");
            if(val1==val2){
                alert("规格名称已存在");
                $(".spec_name_input_"+id+"").val("");
            }else{
                theadData2.splice(0,0,theadName);
            }
        }
    }
}
//删除规格Form值
function  removeEventFormItemVlaue(id) {
    if(confirm("确定要删除？")){
        $(".spec_name_input_"+id+"").val("");
        $(".spec_name_input_"+id+"").removeAttr("data-value");
        $("div[class^='spec_value_tag_"+id+"']").remove();
        closeEventFormItemValue(id);
        if(id==1){theadData1=[];}else{theadData2=[];}
        Groupemplate();
    }
}

//确认规格值输入框显示
function addSpecItemValue(id){
    if($(".spec_name_input_"+id+"").val()==""){
        $(".form-alert-info").slideDown();
        setTimeout(function () {
            $(".form-alert-info").slideUp();
        },2000);
    }else{
        var theadName =$(".spec_name_input_"+id+"").val().replace(/(^\s*)|(\s*$)/g, "");
        if(id==1){
            var val1 =$(".spec_name_input_1").val().replace(/(^\s*)|(\s*$)/g,"");
            var val2 = $(".spec_name_input_2").val().replace(/(^\s*)|(\s*$)/g,"");
            if(val1==val2){
                alert("规格名称已存在");
            }else{
                theadData1.splice(0,0,theadName);
            }
        }else{
            var val1 =$(".spec_name_input_1").val().replace(/(^\s*)|(\s*$)/g,"");
            var val2 = $(".spec_name_input_2").val().replace(/(^\s*)|(\s*$)/g,"");
            if(val1==val2){alert("规格名称已存在");}else{theadData2.splice(0,0,theadName);}
        }
        $(".add_spec_value_input_"+id+"").show();
    }

}

//确定添加值
function addEventFormItemValue(id) {
    var _value = $(".spec_name_value_input_"+id+"").val().replace(/(^\s*)|(\s*$)/g, "");
    var _id = $(".spec_name_value_input_"+id+"").attr("data-value");
    if(_value==""){
        $(".form-alert-info-value").slideDown();
        setTimeout(function () {
            $(".form-alert-info-value").slideUp();
        },2000);
    }else{
        var _index = $(".confirm_input_"+id+"").attr("data-index");
        _index++;
        var vIndex =id+'_'+_index;
        if(!_id){
            _id = "";
        }
        var html ='<div class="spec_value_tag_'+vIndex+' spec_value_tag"> <button type="button" class="spec-close-value" onclick="removeEventFormItemValue('+id+','+_index+')">×</button> <span class="spec_value_span_'+vIndex+'" data-index="'+vIndex+'" data-value="'+_id+'">'+_value+'</span> </div>';
        $(".add_spec_value_input_"+id+"").before(html);
        $(".spec_name_value_input_"+id+"").removeAttr("data-value");
        $(".result_tag_list_"+id+"").hide();
        $(".confirm_input_"+id+"").attr("data-index",_index);
        $(".spec_name_value_input_"+id+"").val("");
        Groupemplate($(".spec_name_input_"+id+"").val(),_value,id,vIndex);

    }
}
//取消添加值
function  closeEventFormItemValue(id) {
    $(".add_spec_value_input_"+id+"").hide();
}
function removeAddFormItemVlaue(id){
    $('.spec_name_value_input_'+id+'').val('');
}
//删除值
function removeEventFormItemValue(id,index){
    if(confirm("确定要删除？")){
        $(".spec_value_tag_"+id+"_"+index+"").remove();
        //$(".spec_table_tbody_tr_"+id+"_"+index+"").remove();
        Groupemplate();
    }
}

//组合规格和规格值
/*var groupTemplateObj={};*/
var theadData1=[];//记录规格
var theadData2 =[];//记录规格
var theadArray =[];//记录规格和标识ID
var tbodyData1 = [];//记录规格值
var tbodyData2 = [];//记录规格值
var tbodyArray1 =[];//记录规格值和标识ID
var tbodyArray2 =[];//记录规格值和标识ID
function  Groupemplate(theadName,_value,indexId,vIndex){

    theadArray = [];
    if($(".spec_name_input_1").val()!="" && $("span[class^='spec_value_span_1_']").length>0){
        var obj = {};
        obj.id = $(".spec_name_input_1").attr("data-showid");
        obj.theadName = $(".spec_name_input_1").val();
        theadArray.push(obj);
    }
    if($(".spec_name_input_2").val()!="" && $("span[class^='spec_value_span_2_']").length>0){
        var obj2 = {};
        obj2.id = $(".spec_name_input_2").attr("data-showid");
        obj2.theadName = $(".spec_name_input_2").val();
        theadArray.push(obj2);
    }
    if(theadArray.length>0){
        var source   = $("#thead-template").html();
        var template = Handlebars.compile(source);
        var tempObj ={};
        tempObj.thead = theadArray;
        $("#spec_table_thead_id").html(template(tempObj));
        createNormsImg();
    }

    tbodyArray1 = [];
    tbodyArray2 = [];
    $.each($("span[class^='spec_value_span_1_']"),function (k,row) {
        var text = $(this).text().replace(/(^\s*)|(\s*$)/g, "");
        var values = $(this).attr("data-value");
        var vIndex = $(this).attr("data-index");
        var obj ={};
        obj.text = text;
        obj.id = values;
        obj.index = vIndex;
        tbodyArray1.push(obj);
    });
    $.each($("span[class^='spec_value_span_2_']"),function (k,row) {
        var text = $(this).text().replace(/(^\s*)|(\s*$)/g, "");
        var values = $(this).attr("data-value");
        var vIndex = $(this).attr("data-index");
        var obj ={};
        obj.text = text;
        obj.id = values;
        obj.index = vIndex;
        tbodyArray2.push(obj);
    });
    //规格值
    if(tbodyArray1.length>0 && tbodyArray2.length>0){
        var array =[];
        for(var i=0;i<tbodyArray1.length;i++){
            for(var k=0;k<tbodyArray2.length;k++){
                var obj  ={};
                obj.text = tbodyArray1[i].text;
                obj.id = tbodyArray1[i].id;
                obj.index_1 = tbodyArray1[i].index;
                obj.index = tbodyArray1[i].index+"_"+tbodyArray2[k].index;
                obj.name = tbodyArray2[k].text;
                obj.value = tbodyArray2[k].id;
                obj.index_2 = tbodyArray2[k].index;
                array.push(obj);
            }
        }
        var source   = $("#tbody-tr-template-2").html();
        var template = Handlebars.compile(source);
        var dobj ={};
        dobj.data = array;
        $("#spec_table_tbody_id").html(template(dobj));
    }else{
        var source   = $("#tbody-tr-template-1").html();
        var template = Handlebars.compile(source);
        var obj ={};
        if(tbodyArray1.length>0){
            obj.data = tbodyArray1;
        }else{
            obj.data = tbodyArray2;
        }
        $("#spec_table_tbody_id").html(template(obj));

        if($("#spec_table_tbody_id tr").length<1){
            $("#spec_table_thead_id").html('');
        }
    }
}


function createNormsImg(){

    if($("span[class^='spec_value_span_1_']").length>0 && $("span[class^='spec_value_span_2_']").length>0){
        $("#spec_norms_thead_name").text($(".spec_name_input_1").val());
        var array =[];
        $.each($("span[class^='spec_value_span_1_']"),function (k,row) {
            var text = $(this).text().replace(/(^\s*)|(\s*$)/g, "");
            var values = $(this).attr("data-value");
            var obj ={};
            obj.text = text;
            obj.value = values;
            obj.id = k+1;
            array.push(obj);
        });
        if(array.length>0){
            console.log(array);
            $(".spec_table_norms_box").show();
            var obj = {};
            obj.data =array;
            var source   = $("#goods-img-template").html();
            var template = Handlebars.compile(source);
            $("#spec_norms_table_tbody_id").html(template(obj));
        }
    }else{
        $(".spec_table_norms_box").hide();
        $("#spec_norms_table_tbody_id").html('');
    }
}
//删除图片
function removeUploadingImg(id){
    if(confirm("确定要删除图片？")){
        $(".uploading-show-img-"+id+" img").attr("src","");
        $(".uploading-show-img-"+id+" img").removeAttr("data-src");
        $(".uploading-show-warp-img-"+id+"").hide();
        $('.uploading-btn-box-'+id+'').show();
    }
}

var iMaxFilesize = 716800; // 1MB
//选择图片
function selectPicture(id){
    //获取选中的文件
    var fileId = document.getElementById('imgfile-'+id+'');
    var oFile = fileId.files[0];
    if(!oFile){
        return false;
    }else{
        //过滤文件类型
        var rFilter = /^(image\/bmp|image\/gif|image\/jpeg|image\/png|image\/tiff)$/i;
        if (! rFilter.test(oFile.type)) {
            alert("请选择图片上传！");
            return false;
        }else{
            //图片大于1MB
            if (oFile.size > iMaxFilesize) {
                alert("图片大小不能大于500KB！");
                return false;
            }else{
                //$.showPreloader("正在上传");
                //准备HTML5 FileReader
                var oReader = new FileReader();
                oReader.onload = function(e){
                    //结果包含DataURL 将使用作为图像的来源
                    var oImageUrl = e.target.result;
                    $(".uploading-show-img-"+id+" img").attr("src",oImageUrl);
                    $(".uploading-show-img-"+id+" img").attr("data-src",oImageUrl);
                    $('.uploading-btn-box-'+id+'').hide();
                    $(".uploading-show-warp-img-"+id+"").show();
                    $("#imgfile-"+id+"").val("");
                };
                //把选中的文件作为DataURL
                oReader.readAsDataURL(oFile);
            }
        }
    }
}

//下一步
function nextStep(type){
    if(type==3){
        var spec_Numbers = false;
        //货号
        $.each($("input[name='spec_Numbers']"),function (index,itemS) {
            if($(this).val()==""){
                spec_Numbers = true;
                return false;
            }
        });
        //规格图片
        var spec_href = false;
        $.each($('img[class="spec_norms_imgs"]'),function (k,rows) {
            var href = $(this).attr("src");
            if(!href){
                spec_href  = true;
                return false;
            }
        });
        var obj ={};
        var specName_1 = $('.spec_name_input_1').val().replace(/(^\s*)|(\s*$)/g, "");
        var specName_2= $('.spec_name_input_2').val().replace(/(^\s*)|(\s*$)/g, "");
        if($('.spec_name_input_1').val().replace(/(^\s*)|(\s*$)/g, "")== ""|| $('.spec_name_input_2').val().replace(/(^\s*)|(\s*$)/g, "")=="" ){
            alert("请先填写规格");
        }else if($("span[class^='spec_value_span_1_']").length<1){
            alert("请先填写规格值");
        }else if($("span[class^='spec_value_span_2_']").length<1){
            alert("请先填写规格值");
        } else if(spec_Numbers){
            alert("先填写完货号");
        }else if(spec_href){
            alert("先全部上传规格图哦");
        }else{
            $('.norms-warp').hide();
            $('.banner-warp').show();
        }
    }else if(type==2){
        $('.norms-warp').show();
        $('.banner-warp').hide();
    }
}
//上传图片
function uploadBannerImg(id){
    var fileId = document.getElementById('upload_img_'+id+'');
    var oFile = fileId.files[0];
    if(!oFile){
        return false;
    }else{
        //过滤文件类型
        var rFilter = /^(image\/bmp|image\/gif|image\/jpeg|image\/png|image\/tiff)$/i;
        if (! rFilter.test(oFile.type)) {
            alert("请选择图片上传！");
            return false;
        }else{
            //图片大于1MB
            if (oFile.size > iMaxFilesize) {
                alert("图片大小不能大于5MB！");
                return false;
            }else{
                //$.showPreloader("正在上传");
                //准备HTML5 FileReader
                var oReader = new FileReader();
                oReader.onload = function(e){
                    //结果包含DataURL 将使用作为图像的来源
                    var oImageUrl = e.target.result;
                    $("#post_photo_pre"+id+"").attr("src",oImageUrl);
                    $("#post_photo_pre"+id+"").attr("data-src",oImageUrl);
                    $("#upload_img_"+id+"").val("");
                };
                //把选中的文件作为DataURL
                oReader.readAsDataURL(oFile);
            }
        }
    }
}
//删除图片
function del_img(id){
    if(confirm("确定要删除?")){
        $('#post_photo_pre'+id+'').attr('src','../../statics/img/600_400.png');
        $("#post_photo_pre"+id+"").removeAttr("data-src");
    }

}

/*详情图片上传*/
var lastIndex =1;
function  lastUploading() {
    var fileId = document.getElementById('last-uploading-img');
    var oFile = fileId.files[0];
    if(!oFile){
        return false;
    }else{
        //过滤文件类型
        var rFilter = /^(image\/bmp|image\/gif|image\/jpeg|image\/png|image\/tiff)$/i;
        if (! rFilter.test(oFile.type)) {
            alert("请选择图片上传！");
            return false;
        }else{
            //图片大于1MB
            if (oFile.size > iMaxFilesize) {
                alert("图片大小不能大于5MB！");
                return false;
            }else{
                //$.showPreloader("正在上传");
                //准备HTML5 FileReader
                var oReader = new FileReader();
                oReader.onload = function(e){
                    //结果包含DataURL 将使用作为图像的来源
                    var oImageUrl = e.target.result;
                    var html = '<p class="del_last_img_index_'+lastIndex+'"><img  name="del_last_img_index[]"  src="'+oImageUrl+'" data-src="'+oImageUrl+'"></p>';
                    $('.window-last-upload').append(html);
                    $("#last-uploading-img").val("");
                    var lasthtml ='<li class="del_last_img_index_'+lastIndex+'"><img src="'+oImageUrl+'"><span class="del_img close-modal" onclick="del_last_img('+lastIndex+')">×</span></li>';
                    $('.last-items-img').append(lasthtml);
                    lastIndex++;
                };
                //把选中的文件作为DataURL
                oReader.readAsDataURL(oFile);
            }
        }
    }
}
//删除图片
function del_last_img(index){
    if(confirm('确定要删除图片？')){
        $('.del_last_img_index_'+index+'').remove();
    }
}


//提交
function  submitForm(){
    if(!$("#post_photo_pre1").attr("data-src")){
        alert("商品第一张轮播图为必传！");
    }else if($(".window-last-upload p").length<1){
        alert("商品详情最少上传图片一张");
    }else{
        var obj = {};
        var array1=[];
        var array2=[];
        var array1obj1={},array1obj2={};
        if($('.spec_name_input_1').attr("data-value")){
            array1obj1.classifyId = $('.spec_name_input_1').attr("data-value");
        }else{
            array1obj1.classifyId ="";
        }
        array1obj1.classifyName = $('.spec_name_input_1').val().replace(/(^\s*)|(\s*$)/g, "");
        array1=array1obj1;
        if($('.spec_name_input_2').attr("data-value")){
            array1obj2.specId = $('.spec_name_input_2').attr("data-value");
        }else{
            array1obj2.specId ="";
        }
        array1obj2.specName= $('.spec_name_input_2').val().replace(/(^\s*)|(\s*$)/g, "");
        array2=array1obj2;
        obj.classifyData=array1;
        obj.specData=array2;

        var array_value =[];
        $.each($("#spec_table tbody tr"),function (index,item) {
            var index = $(this).attr("data-index");
            var classifyDetailName = $(".tbody-form-text-text-"+index+"").text();
            var classifyDetailId = "";
            if($(".tbody-form-text-text-"+index+"").attr("data-id")&&$(".tbody-form-text-text-"+index+"").attr("data-id")!=""){
                classifyDetailId = $(".tbody-form-text-text-"+index+"").attr("data-id");
            }
            var specDetailName = $(".tbody-form-text-name-"+index+"").text();
            var specDetailId = "";
            if($(".tbody-form-text-text-"+index+"").attr("data-id")&&$(".tbody-form-text-text-"+index+"").attr("data-id")!=""){
                specDetailId = $(".tbody-form-text-name-"+index+"").attr("data-id");
            }
            var productBn = $(".spec-numbers-"+index+"").val();
            var barCode = $(".spec-barcode-"+index+"").val();
            var status = $(".selected-"+index+"").val();
            var obj1 ={};
            obj1.classifyDetailName = classifyDetailName;
            obj1.classifyDetailId = classifyDetailId;
            obj1.specDetailName = specDetailName;
            obj1.specDetailId = specDetailId;
            obj1.productBn = productBn;
            obj1.barCode = barCode;
            obj1.status = status;
            array_value.push(obj1);
        });
        obj.productData= array_value;
        var imgArray = [];
        $.each($('img[class="spec_norms_imgs"]'),function (j,rows) {
            var imgsrc = $(this).attr("data-src");
            imgArray.push(imgsrc);
        });
        obj.classifyImgData= imgArray;
        //轮播图
        var bannerList =[];
        if($('#post_photo_pre1').attr('data-src')){
            var photh =$('#post_photo_pre1').attr('data-src');
            bannerList.push(photh);
        }
        if($('#post_photo_pre2').attr('data-src')){
            var  photh =$('#post_photo_pre2').attr('data-src');
            bannerList.push(photh);
        }
        if($('#post_photo_pre3').attr('data-src')){
            var  photh =$('#post_photo_pre3').attr('data-src');
            bannerList.push(photh);
        }
        if($('#post_photo_pre4').attr('data-src')){
            var  photh =$('#post_photo_pre4').attr('data-src');
            bannerList.push(photh);
        }
        if($('#post_photo_pre5').attr('data-src')){
            var photh =$('#post_photo_pre5').attr('data-src');
            bannerList.push(photh);
        }
        if($('#post_photo_pre6').attr('data-src')){
            var photh =$('#post_photo_pre6').attr('data-src');
            bannerList.push(photh);
        }
        obj.goodsNavigateImgData =bannerList;
        var detailsImg =[];
        $.each($(".window-last-upload p img"),function (k,row) {
            var srcUrl = $(this).attr('data-src');
            detailsImg.push(srcUrl);
        });
        obj.goodsDetailImgData = detailsImg;
        var goodId =$("#goodsId").val();
        if(confirm("确定要提交？")){
            $("#goods-create-button").attr("disabled","disabled");
            $.post("/goods/goods/create?tag=1&goods_id="+goodId+"&step=2", obj, function(data,status){
                if(data){

                }
            });
        }
    }
}
//更新提交
function  submitUpdateForm(){
    if(!$("#post_photo_pre1").attr("src")){
        alert("商品第一张轮播图为必传！");
    }else if($(".window-last-upload p").length<1){
        alert("商品详情最少上传图片一张");
    }else{
        var obj = {};
        var array1=[];
        var array2=[];
        var array1obj1={},array1obj2={};
        if($('.spec_name_input_1').attr("data-value")){
            array1obj1.classifyId = $('.spec_name_input_1').attr("data-value");
        }else{
            array1obj1.classifyId ="";
        }
        array1obj1.classifyName = $('.spec_name_input_1').val().replace(/(^\s*)|(\s*$)/g, "");
        array1=array1obj1;
        if($('.spec_name_input_2').attr("data-value")){
            array1obj2.specId = $('.spec_name_input_2').attr("data-value");
        }else{
            array1obj2.specId ="";
        }
        array1obj2.specName= $('.spec_name_input_2').val().replace(/(^\s*)|(\s*$)/g, "");
        array2=array1obj2;
        obj.classifyData=array1;
        obj.specData=array2;

        var array_value =[];
        $.each($("#spec_table tbody tr"),function (index,item) {
            var index = $(this).attr("data-index");
            var classifyDetailName = $(".tbody-form-text-text-"+index+"").text();
            var classifyDetailId = "";
            if($(".tbody-form-text-text-"+index+"").attr("data-id")&&$(".tbody-form-text-text-"+index+"").attr("data-id")!=""){
                classifyDetailId = $(".tbody-form-text-text-"+index+"").attr("data-id");
            }
            var specDetailName = $(".tbody-form-text-name-"+index+"").text();
            var specDetailId = "";
            if($(".tbody-form-text-text-"+index+"").attr("data-id")&&$(".tbody-form-text-text-"+index+"").attr("data-id")!=""){
                specDetailId = $(".tbody-form-text-name-"+index+"").attr("data-id");
            }
            var productBn = $(".spec-numbers-"+index+"").val();
            var barCode = $(".spec-barcode-"+index+"").val();
            var status = $(".selected-"+index+"").val();
            var obj1 ={};
            obj1.classifyDetailName = classifyDetailName;
            obj1.classifyDetailId = classifyDetailId;
            obj1.specDetailName = specDetailName;
            obj1.specDetailId = specDetailId;
            obj1.productBn = productBn;
            obj1.barCode = barCode;
            obj1.status = status;
            array_value.push(obj1);
        });
        obj.productData= array_value;
        var imgArray = [];
        $.each($('img[class="spec_norms_imgs"]'),function (j,rows) {
            var imgsrc = $(this).attr("data-src");
            imgArray.push(imgsrc);
        });
        obj.classifyImgData= imgArray;
        //轮播图
        var bannerList =[];
        if($('#post_photo_pre1').attr('data-src')&&$('#post_photo_pre1').attr('data-src')!=''){
            var photh =$('#post_photo_pre1').attr('data-src');
            bannerList.push(photh);
        }
        if($('#post_photo_pre2').attr('data-src')&&$('#post_photo_pre2').attr('data-src')!=''){
            var  photh =$('#post_photo_pre2').attr('data-src');
            bannerList.push(photh);
        }
        if($('#post_photo_pre3').attr('data-src')&&$('#post_photo_pre3').attr('data-src')!=''){
            var  photh =$('#post_photo_pre3').attr('data-src');
            bannerList.push(photh);
        }
        if($('#post_photo_pre4').attr('data-src')&&$('#post_photo_pre4').attr('data-src')!=''){
            var  photh =$('#post_photo_pre4').attr('data-src');
            bannerList.push(photh);
        }
        if($('#post_photo_pre5').attr('data-src')&&$('#post_photo_pre5').attr('data-src')!=''){
            var photh =$('#post_photo_pre5').attr('data-src');
            bannerList.push(photh);
        }
        if($('#post_photo_pre6').attr('data-src')&&$('#post_photo_pre6').attr('data-src')!=''){
            var photh =$('#post_photo_pre6').attr('data-src');
            bannerList.push(photh);
        }
        obj.goodsNavigateImgData =bannerList;
        var detailsImg =[];
        $.each($(".window-last-upload p img"),function (k,row) {
            var srcUrl = $(this).attr('data-src');
            detailsImg.push(srcUrl);
        });
        obj.goodsDetailImgData = detailsImg;
        var goodId =$("#goodsId").val();
        if(confirm("确定要提交？")){
            $("#goods-update-button").attr("disabled","disabled");
            $.post("/brand/goods/update?tag=1&id="+goodId, obj, function(data,status){
                if(data){

                }
            });
        }
    }
}
