<?php
namespace common\components;


use common\models\BrandUser;
use common\models\Store;
use common\models\Supplier;
use common\models\TeamUserRelation;
use Yii;


use yii\helpers\Html;
use yii\httpclient\Client;

class Common
{
    /**
     * 通过图片地址和图片宽高渲染图片
     * @param  string $image_url
     * @param  string $px
     * @return mixed
     */


    public static function getImage($image_url,$px='30px')
    {
        return $image_url? Html::img($image_url,['width'=>$px,'height'=>$px]):$image_url;
    }
    /**
     * 通过图片地址和类名渲染图片
     * @param  string $image_url
     * @param  string $preview_class
     * @param  array $width_height
     * @return mixed
     */
    public static function getImagePreview($image_url,$preview_class,$width_height=['width'=>'30px','height'=>'30px'])
    {
        $image_url = $image_url? $image_url:'';
        return Html::img($image_url,['width' => $width_height['width'],'height'=> $width_height['height'],'class'=>$preview_class]);
    }
    /**
     * 获取地区信息
     * @param  string $keywords
     * @param  string $level
     * @return mixed
     */
    public static function getRegionSearch($keywords=null,$level=null){
        $data = GaoDe::getDistrict(['keywords'=>$keywords,'level'=>$level]);
        return $data['status']==1?$data['districts'][0]['districts']:[];
    }
    /**
     * 通过地区信息获取经纬度
     * @param  string $city
     * @param  string $address
     * @return mixed
     */
    public static function getLocation($city,$address)
    {
        $data = GaoDe::getGeo(['city'=>$city,'address'=>$address]);
        return $data['status']==1?$data['geocodes'][0]['location']:[];
    }
    /**
     * 创建不重复的随机Uid
     * strtoupper() 函数把字符串转换为大写
     * substr() 截取其中部分字符串
     * @return mixed
     */
    public static function getUid(){
        mt_srand((double)microtime()*10000+rand(10000,99999));
        $charid = strtoupper(md5(uniqid(mt_rand(), true)));
        $uid = substr($charid,10, 4).substr($charid,20,12);
        return $uid;
    }
    /**
     * 通过URL和参数发起远程请求
     * @param  string $url  请求URL路径
     * @param  array $params  请求的参数
     * @param  string $formatter  参数格式化
     * @return mixed
     */
    public static function requestServer($url,$params,$formatter = Client::FORMAT_JSON)
    {
        $client = new Client();
        $response = $client->createRequest()
            ->setFormat($formatter)
            ->setMethod('post')
            ->setUrl($url)
            ->setData($params)
            ->send();
        $content = $response->getContent();
        return $content;
    }

    /**
     * 通过后端用户ID获取相应的品牌ID数组.
     * @return mixed
     */
    public static function getBrandIdArrByUserId()
    {
        $brand_id_arr = [];
        $user_id  = Yii::$app->getUser()->id;
        $brand_user_arr = BrandUser::find()->where(['=','user_id',$user_id])->asArray()->all();
        foreach ($brand_user_arr as $brand_user)
        {
            $brand_id_arr[] = $brand_user['brand_id'];
        }
        return $brand_id_arr;
    }
    /**
     * 通过后端用户ID获取相应的门店ID数组.
     * @return mixed
     */
    public static function getStoreIdArrByUserId()
    {
        $store_id_arr=[];
        $user_id = Yii::$app->user->id;
        $supplier = Supplier::find()->where(['=','user_id',$user_id])->asArray()->one();
        $stores = Store::find()->where(['=','supplier_id',$supplier['id']])->asArray()->all();
        foreach ($stores as $store){
            $store_id_arr[] = $store['id'];
        }
        return $store_id_arr;
    }
    public static function getImgData($img_path)
    {
        $imgtxt = self::base64EncodeImage($img_path);
        return $imgtxt;
    }
    /**
     * 将图片转化为base64的数据
     * @param  string $image_file  图片的可直接访问路径
     * @return mixed  图片处理后的base64数据字符串
     */
    public static function base64EncodeImage ($image_file)
    {
        $image_info = getimagesize($image_file);
//        $image_data = fread(fopen($image_file, 'r'), filesize($image_file));
        $image_data = file_get_contents($image_file);
        $base64_image = 'data:' . $image_info['mime'] . ';base64,' . chunk_split(base64_encode($image_data));
        return $base64_image;
    }
    /**
     * 生成商品编码.（要保证全局唯一）
     * @return mixed
     */
    public static function generateGoodsBn()
    {
        $h_code = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X'];
        $goods_bn = $h_code[intval(date('H'))] . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 4) . sprintf('%02d', rand(0, 99));
        return $goods_bn;
    }

    /**
     * 生成随机码
     * @param $length
     * @return string
     */
    public  static function randomKey($length) {
        $pool = array_merge(range(0,9), range('a', 'z'),range('A', 'Z'));
        $key = '';
        for($i=0; $i < $length; $i++) {
            $key .= $pool[mt_rand(0, count($pool) - 1)];
        }
        return $key;
    }


    /*
     * 通过登录的用户确认对应的小组订单
     * 先通过简单的排除admin 执行(未判断)
     */

    public static function getPower()
    {
        $user_id = Yii::$app->user->id;
        $team_user_relation = TeamUserRelation::findOne(['user_id' => $user_id]);
        if(is_object($team_user_relation)){
            return $team_id = $team_user_relation->team_id;
        }
            return $user_id;
    }

    public static function getUser()
    {
       return $user_id = Yii::$app->user->id;
    }
}