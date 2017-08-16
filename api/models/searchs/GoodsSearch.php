<?php

namespace frontend\models\searchs;

use common\models\GoodsAppRecord;
use common\models\GoodsDetail;
use common\models\GoodsNavigate;
use common\models\GoodsSpecificationImages;
use common\models\Inventory;
use common\models\Product;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Goods;
use yii\helpers\ArrayHelper;
use yii\data\Pagination;
use common\models\Brand;
use yii\web\NotFoundHttpException;


/**
 * GoodsSearch represents the model behind the search form about `common\models\Goods`.
 */
class GoodsSearch extends Model
{
    public $name;
    public $cids;
    public $app_id;
    public $goods_code;
    public $hd_sj;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_code', 'name','cids','app_id','hd_sj'], 'safe'],
            [['goods_code','name'],'trim'],
//            ['hd_sj']
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return array
     */
    public function search($params)
    {

        $query = Goods::find()
            ->select('*')
            ->orderBy(['id'=>SORT_DESC]);

        $this->load($params);


        $query->andFilterWhere([
            'in','category_id',$this->cids
        ]);
        if($this->hd_sj === 'yes')//排除上架商品
        {
            $SJGoodsIds = GoodsAppRecord::getAllSJGoodsIdByApp($this->app_id);
            $query->andFilterWhere(['not in','id',$SJGoodsIds]);
        }
        $query->andFilterWhere(['goods_code'=>$this->goods_code]);
        $query->andFilterWhere(['like', 'name', $this->name]);
        //分页
        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count ]);
        //获取一页的数据
        $data = $query->offset($pagination->offset)->limit($pagination->limit)->all();
        $goods = [];
        $goodsIds = ArrayHelper::getColumn($data, 'id');
        $goodsImgs = GoodsNavigate::getGoodsImgsByGoodsIds($goodsIds);
        $saleGoodsStoreNum = GoodsAppRecord::getAllGoodsSaleAppInfo($goodsIds,$this->app_id);
        foreach ($data as $d)
        {
            $inventory = Inventory::getGoodsLowerstPriceInventory($d->id);
            $goods[] = [
                'goods_id' => $d->id,
                'goods_code' => $d->goods_code,
                'goods_price' => $inventory?$inventory['sale_price']/100:$d->lowest_price, //售价
                'commission' => $inventory?($inventory['sale_price']-$inventory['cooperate_price'])/100:0,//佣金=售价-异业结算价
                'settlement_price' => $inventory?$inventory['cooperate_price']/100:$d->lowest_price,//结算价
                'goods_img' => isset($goodsImgs[$d->id])?QINIU_URL.$goodsImgs[$d->id]:'',
                'sale_store_num' => isset($saleGoodsStoreNum[$d->id])?$saleGoodsStoreNum[$d->id]['app_num']:0,
                'name'=>$d->name,
                'is_selected' => isset($saleGoodsStoreNum[$d->id])?$saleGoodsStoreNum[$d->id]['is_selected']:false,
                'threshold' => $d->threshold
            ];
        }
        return [
            'goods' => $goods,
            'pagination' => $pagination
        ];
    }
    public function search_my_goods($params)
    {
        $this->load($params);
        $query = GoodsAppRecord::find()
            ->select('goods_id')
            ->where(['app_id'=>$this->app_id])
            ->orderBy(['id'=>SORT_DESC]);
        //分页
        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count ]);
        //获取一页的数据
        $data = $query->offset($pagination->offset)->limit($pagination->limit)->all();
        $goods = [];
        $goodsIds = ArrayHelper::getColumn($data, 'goods_id');
        $goodsInfo = Goods::getGoodsByIds($goodsIds);
        $goodsImgs = GoodsNavigate::getGoodsImgsByGoodsIds($goodsIds);
        $saleGoodsStoreNum = GoodsAppRecord::getAllGoodsSaleAppInfo($goodsIds,$this->app_id);
        foreach ($data as $d)
        {
            $inventory = Inventory::getGoodsLowerstPriceInventory($d->goods_id);
            $goods[] = [
                'goods_id' => $d->goods_id,
                'goods_code' => $goodsInfo[$d->goods_id]['goods_code'],
                'goods_price' => $inventory?$inventory['sale_price']/100:$goodsInfo[$d->goods_id]['lowest_price'], //售价
                'commission' => $inventory?($inventory['sale_price']-$inventory['cooperate_price'])/100:0,//佣金=售价-异业结算价
                'settlement_price' => $inventory?$inventory['cooperate_price']/100:$goodsInfo[$d->goods_id]['lowest_price'],//结算价
                'goods_img' => isset($goodsImgs[$d->goods_id])?QINIU_URL.$goodsImgs[$d->goods_id]:'',
                'sale_store_num' => isset($saleGoodsStoreNum[$d->goods_id])?$saleGoodsStoreNum[$d->goods_id]['app_num']:0,
                'name'=>$goodsInfo[$d->goods_id]['name'],
                'is_selected' => isset($saleGoodsStoreNum[$d->goods_id])?$saleGoodsStoreNum[$d->goods_id]['is_selected']:false,
                'threshold' => $goodsInfo[$d->goods_id]['threshold']
            ];
        }
        return [
            'goods' => $goods,
            'pagination' => $pagination
        ];
    }

    public function search_goods_detail($params)
    {
        $this->load($params);
        $goods = Goods::find()->where(['goods_code'=>$this->goods_code])->asArray()->one();
        $inventory = Inventory::getGoodsLowerstPriceInventory($goods['id']);
        $goods['goodsImages'] = GoodsNavigate::getGoodsImageByGoodsId($goods['id'],true);
        $goods['brand_name'] = Brand::getBrandNameById($goods['brand_id']);
        $goodsInventoryInfo = Inventory::getGoodsInventoryInfo($goods['id']);
        $goods['goods_price'] = $inventory?$inventory['sale_price']/100:$goods['lowest_price'];//售价
        $goods['commission'] = $inventory?($inventory['sale_price']-$inventory['cooperate_price'])/100:0;//佣金=售价-异业结算价
        $goods['settlement_price'] = $inventory?$inventory['cooperate_price']/100:$goods['lowest_price'];//结算价 对应数据库异业结算价
        $goods['supply_stores_num'] = $goodsInventoryInfo['goods_stores_num'];//商品提供商数量
        $goodsAppInfo = GoodsAppRecord::getOneGoodsSaleAppInfo($goods['id'],$this->app_id);
        $goods['sale_stores_num'] = $goodsAppInfo['app_num'];
        $goods['is_select'] = $goodsAppInfo['is_select'];
        $goods['products'] = Product::getProductsByGoodsId($goods['id']);
        $goods['detail_images'] = GoodsDetail::getDetailImageByGoodsId($goods['id']);

        return $goods;
    }

    public function load($data, $formName = null)
    {
        $app = Yii::$app->user->getIdentity();
        if($app){
            $this->app_id = $app->app_id;
        }

        return parent::load($data, $formName); // TODO: Change the autogenerated stub
    }
}

