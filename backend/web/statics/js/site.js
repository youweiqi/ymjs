/**
 * modal框js
 * @author 上班偷偷打酱油 <xianan_huang@163.com>
 */
window.fn = function(el,requestUrl,data,title){
     $(el).click(function () {
            $('.modal-title').html(title);
            $.ajax({
                url: requestUrl,
                type: "get",
                data: {id:$(this).closest('tr').attr('data-key')},
                success: function(data) {
                    $('.modal-body').html(data);
                },
                beforeSend:function(){
                    $('.modal-body').html('加载中...');
                }
            });
    });
}

/**
 * 模态框数据提交
 * @author 上班偷偷打酱油 <xianan_huang@163.com>
 */
window.commit = function(el,requestUrl){
     $(el).click(function () {
            $.ajax({
                url: requestUrl,
                type: "POST",
                data: $('form').serialize(),
                success:function(dt) {
                    if(dt){
                        $('.modal-body').html(dt);
                    }else{
                        window.location.reload()
                    }
                }
            });
    });
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
