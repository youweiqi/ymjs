<?php
namespace backend\libraries;

use common\components\Common;
use Yii;
use yii\data\ArrayDataProvider;

class ThirdPartyLib{
    /*
       转化第三方接口的字段为本库字段
     */
  public static function ChangeGoods($data){
      if(!empty($data)&&is_array($data)){
          $goods_data=[];
            foreach ($data as $value)
            {
                $goods['api_goods_id']=$value['goodsId'];
                $goods['brand_id']=$value['brandId'];
                $goods['suggested_price']=$value['suggestedPrice'];
                $goods['lowest_price']=$value['lowestPrice'];
                $goods['talent_limit']=$value['talentLimit'];
                $goods['threshold']=$value['threshold'];
                $goods['ascription']=$value['ascription'];
                $goods['talent_display']=$value['talentDisplay'];
                $goods['discount']=$value['discount'];
                $goods['score_rate']=$value['scoreRate'];
                $goods['self_support']=$value['selfSupport'];
                $goods['channel']=$value['channel'];
                $goods['goods_code']='G-'.$value['goodsCode'];
                $goods['name']=$value['name'];
                $goods['label_name']=$value['labelName'];
                $goods['unit']=$value['unit'];
                $goods['remark']=$value['remark'];
                $goods['wx_small_imgpath']=$value['wxSmallImgpath'];
                $goods_data[]=$goods;
            }
          return $goods_data;
      }
  }

  public static function getGoods($goods_diff)
  {

      $goods_diff = array_values($goods_diff);
      $url= BIZ_BASE_URL.BIZ_LOOK_GOODS_LISTS;
      $param=['goodsIdList'=>$goods_diff];
      $result = json_encode($param);
      $data= base64_encode($result);
      $sign= strtoupper(md5($data.BIZ_SECRET));
      $params = ['appKey'=>BIZ_APP_KEY,'data'=>$data,'sign'=>$sign];
      $content = Common::requestServer($url, $params);
      $result1 = json_decode($content,true);
      $results=$result1['data'];
      return $results;
  }







}



