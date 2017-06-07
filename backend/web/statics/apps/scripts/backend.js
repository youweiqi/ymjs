$(function () {
    $('#search-button').click(function() {
        var filters = $('.filters');
        if(filters.hasClass('hidden-search')){
            filters.removeClass('hidden-search');
            filters.addClass('show-search');
        }
    });
});
//上传图片
function uploadImg(id){
    var file_obj = document.getElementById(id);
    var oFile = file_obj.files[0];
    if(!oFile){
        return false;
    }else{
        //过滤文件类型
        var rFilter = /^(image\/bmp|image\/gif|image\/jpeg|image\/png|image\/tiff)$/i;
        if (! rFilter.test(oFile.type)) {
            alert("请选择图片上传！");
            return false;
        }else{
            //图片大于5MB
            if (oFile.size > 5242880) {
                alert("图片大小不能大于5MB！");
                return false;
            }else{
                //准备HTML5 FileReader
                var oReader = new FileReader();
                oReader.onload = function(e){
                    //结果包含DataURL 将使用作为图像的来源
                    var oImageUrl = e.target.result;
                    $('#'+id+'-preview').attr("src",oImageUrl);
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
        $('#'+id+'-preview').attr('src','../../statics/images/default/600_400.png');
        $('#'+id+'').val('');
    }

}
function getObjectURL(file) {
    var url = null ;
    if (window.createObjectURL!=undefined) {
        url = window.createObjectURL(file) ;
    } else if (window.URL!=undefined) {
        url = window.URL.createObjectURL(file) ;
    } else if (window.webkitURL!=undefined) {
        url = window.webkitURL.createObjectURL(file) ;
    }
    return url ;
}
function setImgInfo(imgUrl,img_width_id,img_height_id){
    $("<img/>").attr("src",imgUrl).load(function() {
        $("#"+img_width_id).val(this.width);
        $("#"+img_height_id).val(this.height);
    });
}


