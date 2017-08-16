<?php
use yii\widgets\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\widget\BreadcrumbsWidget;

?>
<div class="w1024px">
    <div class="breadcrumb-box">
        <ol class="breadcrumb">
            <?=BreadcrumbsWidget::widget(['route'=>'goods/search','params'=>['keyword'=>$this->params['keyword']]])?>
        </ol>
    </div>
    <div class="list-where clear">
        <div class="list-where-left">
            <ul class="clear">
                <li class="active"><a href="javascript:;">最新</a></li>
                <li><a href="javascript:;">销量</a></li>
                <li><a href="javascript:;">佣金</a></li>
                <!--状态class有  price  price-asc price-desc-->
                <li class="price"><a  href="javascript:;">价格</a></li>
            </ul>
        </div>
        <div class="list-where-right">
            <div class="list-where-right-l">
                <input type="checkbox"  <?=($hd_sj=='yes'?"checked":'')?> name="quux" id="checkboxId"><span>隐藏已上架商品</span>
            </div>
            <div class="f-pager">
                <a  class="fp-prev disabled" href="javascript:;"> < </a>
                <span class="fp-text">
                    <b>1</b>
                    <em>/</em>
                    <i>16</i>
                </span>
                <a  class="fp-next" href="javascript:;"> > </a>
            </div>
        </div>
    </div>
    <div class="content">
        <ul class="list-content clear">
<!--            <li>-->
<!--                <a class="img" href="#">-->
<!--                    <img src="../images/list/a.png">-->
<!--                </a>-->
<!--                <div class="con-border">-->
<!--                  <div class="price-box clear">-->
<!--                      <div class="price">-->
<!--                          <span>¥</span>-->
<!--                          <strong>18.00</strong>-->
<!--                      </div>-->
<!--                      <div class="d-right">-->
<!--                          <div class="brokerage">佣金</div>-->
<!--                          <div class="lab-price">¥99.99</div>-->
<!--                      </div>-->
<!--                  </div>-->
<!--                  <h4 class="name"><a href="javascript:;">U/TI尤缇 潮流无袖军绿色女U/TI尤缇 潮流无袖军绿色女</a></h4>-->
<!--                  <div class="sales clear">-->
<!--                      <span>销量:28172</span>-->
<!--                      <span class="f">28人正在卖</span>-->
<!--                  </div>-->
<!--                </div>-->
<!--                <div class="add-shop-box">-->
<!--                    <a class="add-shop" href="javascript:;"><span class="bg"></span><span>加入货架</span></a>-->
<!--                </div>-->
<!--            </li>-->
            <?php foreach ($data['goods'] as $d) {?>
            <li>
                <a class="img" href="<?=Url::to(["goods/detail","gcode"=>$d['goods_code']])?>" target="_blank">
                    <img src="<?= $d['goods_img'] ?>">
                    <div class="img-price">结算价 ¥<?=$d['settlement_price']?></div>
                </a>
                <div class="con-border">
                    <div class="price-box clear">
                        <div class="price">
                            <span>¥</span>
                            <strong><?=$d['goods_price']?></strong>
                        </div>
                        <div class="d-right">
                            <div class="brokerage">佣金</div>
                            <div class="lab-price">¥<?=$d['commission']?></div>
                        </div>
                    </div>
                    <h4 class="name"><?=Html::a($d['name'],Url::to(["goods/detail","gcode"=>$d['goods_code']]),['target'=>'_blank'])?></h4>
                    <div class="sales clear">
                        <span>销量:28172</span>
                        <span class="f"><?=$d['sale_store_num']?>人正在卖</span>
                    </div>
                </div>
                <div class="add-shop-box <?=$d['is_selected']?'disabled':''?>" data="<?=$d['goods_id']?>">
                    <a class="add-shop"  href="javascript:;"><span class="bg"></span><span class="add-shope-box-title"><?=$d['is_selected']?'已上架':'加入货架'?></span></a>
                </div>
            </li>
            <?php }?>
        </ul>

        <div class="pagination-box">
            <nav aria-label="Page navigation" style="text-align: center">
            <?php echo LinkPager::widget([
                'pagination' => $data['pagination'],
            ]);?>
            </nav>
        </div>

    </div>
</div>
<?php
$api_url = Url::to(["goods/add"]);
$cur_url = Url::to(["goods/search","keyword"=>$this->params['keyword']??'']);

$js = <<<JS
$(function () {
        var cur_url = '$cur_url';
        $('.add-shop-box').click(function () {
            var _this = $(this);
            var goods_id = _this.attr('data');
            $.ajax({
                url: "$api_url",
                method: "POST",
                data: { goods_id : goods_id },
                dataType: 'json'
            }).success(function (data) {
                    if(data.status == 'succ')
                    {
                        _this.attr('class',"add-shop-box disabled");
                        _this.find('.add-shope-box-title').html('已上架') 
                    }else{
                        alert('系统错误 请联系管理员');
                    }
                }
            );
        })
        $('#checkboxId').click(function() {
            if($(this).is(':checked')){
                location.href = cur_url+'&hd_sj='+'yes';
            }else{
                location.href = cur_url+'&hd_sj='+'no';
            }
        })
    })
JS;
$this->registerJs($js,3);
?>
<script>

</script>
