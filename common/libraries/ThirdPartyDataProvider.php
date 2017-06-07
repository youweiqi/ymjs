<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 18/4/17
 * Time: PM6:31
 * 继承baseDataProvider 实现该下的三个接口 完成分页
 * 自定义DataProvider 数据提供者
 */

namespace common\libraries;
use common\components\Common;
use common\helpers\ArrayHelper;
use common\models\Goods;
use Yii;
use yii\data\BaseDataProvider;

class ThirdPartyDataProvider extends BaseDataProvider
{
    public $key;
   public function init()
   {
       parent::init();
   }

   protected function prepareKeys($models)
   {
       if ($this->key !== null) {
           $keys = [];

           foreach ($models as $model) {
               if (is_string($this->key)) {
                   $keys[] = $model[$this->key];
               } else {
                   $keys[] = call_user_func($this->key, $model);
               }
           }

           return $keys;
       } else {
           return array_keys($models);//属性
       }
   }
    /*
     * 调用接口获取count;
     */
   protected function prepareTotalCount()
   {
       $url = Yii::$app->params['bizBaseUrl'].Yii::$app->params['bizGoodsList'];
       $param = ['pageNum' => 1, 'pageSize' => 1];
       $result = json_encode($param);
       $data = base64_encode($result);
       $sign = strtoupper(md5($data . Yii::$app->params['bizSecret']));
       $params = ['appKey' => Yii::$app->params['bizAppKey'], 'data' => $data, 'sign' => $sign];
       $content = Common::requestServer($url, $params);
       $result = json_decode($content, true);
       if ($result['code'] == 10000) {
           Yii::$app->session->setFlash('success',$result['message']);
           return  intval($result['data']['count']);
       }else{
           Yii::$app->session->setFlash('error',$result['message']);
           return 0;
       }
   }
   /*
    * @根据totalCount 和$pageNum 和$pageSize 实现分页类
    * @$ids 获取数组下的属性
    * @$goods 到库里面查询已经存在的api_goods_id
    * $models 是获取到的数组
    */
    protected function prepareModels()
    {
        $models = [];
        $pagination = $this->getPagination();
        $pagination->totalCount = $this->getTotalCount();
        $pageNum = $pagination->getPage()+1;
        $pageSize = $pagination->getLimit();
        $models = $this->getDataFromGoodsApi($pageNum,$pageSize);
        $ids = ArrayHelper::getColumn($models,'goodsId');
        $goods = Goods::find()->where(['in','api_goods_id',$ids])->asArray()->all();
        $api_goods_ids = ArrayHelper::getColumn($goods,'api_goods_id');
        foreach ($models as $k => $v)
        {
            $models[$k]['exist'] = in_array($v['id'], $api_goods_ids) ? true : false;
        }
        return $models;
    }

    /*
     * @$pageNum 页数
     * @pageSize 条数
     * @return 接口下的list 数组
     */
    private function getDataFromGoodsApi($pageNum,$pageSize)
    {
        $url = Yii::$app->params['bizBaseUrl'].Yii::$app->params['bizGoodsList'];
        $param = ['pageNum' => $pageNum, 'pageSize' => $pageSize];
        $result = json_encode($param);
        $data = base64_encode($result);
        $sign = strtoupper(md5($data . Yii::$app->params['bizSecret']));
        $params = ['appKey' => Yii::$app->params['bizAppKey'], 'data' => $data, 'sign' => $sign];
        $content = Common::requestServer($url, $params);
        $result = json_decode($content, true);
        if ($result['code'] == 10000) {
            Yii::$app->session->setFlash('success',$result['message']);
            return $result['data']['list'];
        }else{
            Yii::$app->session->setFlash('error',$result['message']);
            return [];
        }
    }
}