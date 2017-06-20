<?php

namespace backend\modules\goods\models\search;

use backend\libraries\BrandLib;
use common\models\Category;
use common\models\Product;
use console\libraries\StoreFileLib;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Goods;
use yii\helpers\ArrayHelper;

/**
 * GoodsSearch represents the model behind the search form of `common\models\Goods`.
 */
class GoodsSearch extends Goods
{
    public $brand_name;
    public $category_parent_name;
    public $category_name;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'brand_id', 'suggested_price', 'lowest_price', 'category_parent_id', 'category_id', 'talent_limit', 'threshold', 'ascription', 'talent_display', 'discount', 'operate_costing', 'score_rate', 'self_support', 'channel', 'api_goods_id'], 'integer'],
            [['brand_name','name_cn','name_en','goods_code', 'name', 'spec_desc', 'service_desc', 'label_name', 'unit', 'remark', 'online_time', 'offline_time', 'create_time', 'wx_small_imgpath'], 'safe'],
            [['id','brand_id','goods_code','name','category_parent_name','category_name'],'trim']
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
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Goods::find()
            ->where(['api_goods_id'=>'0'])
            ->select('goods.*,brand.name_en,brand.name_en')
            ->joinWith(['brand']);//根据需要去默认排序（表.字段）

        // add conditions that should always apply here
        $pageSize = isset($params['per-page']) ? intval($params['per-page']) : 20;
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['offline_time'=>SORT_DESC,'id'=>SORT_DESC]],
            'pagination' =>  ['pageSize' => $pageSize,],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'goods.id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'goods_code', $this->goods_code])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere([
                'or',
                ['like', 'brand.name_cn', $this->brand_name],
                ['like', 'brand.name_en', $this->brand_name],
            ]);

        return $dataProvider;
    }

    /*
    * 获取导出的query
    */
    public function getExportQuery($params)
    {
        $this->load($params);
        $query = Goods::find()->where(['=','api_goods_id',0])
            ->select('goods.*,brand.name_en,brand.name_en,goods_commission.commission')
            ->joinWith(['brand','category','goods_commission'])
            ->orderBy(['goods.id'=>SORT_DESC]);
        if($this->brand_name) {
            $brandIdArr = BrandLib::getBrandId($this->brand_name);
            if ($brandIdArr){
                $query->andFilterWhere(['in','goods.brand_id',$brandIdArr]);
            }else{
                return false;
            }
        }
        $query->andFilterWhere([
            'goods.id'=>$this->id,

        ])
            ->andFilterWhere(['like', 'goods_code', $this->goods_code])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['>=', 'goods.online_time', $this->online_time])
            ->andFilterWhere(['<=', 'goods.offline_time', $this->offline_time])
            ->andFilterWhere(['like', 'category.name', $this->category_parent_name])
            ->andFilterWhere(['like', 'category.name', $this->category_name]);
        $goodsIds = $query->select('goods.id')->all();
        $product_goods_ids = ArrayHelper::getColumn($goodsIds,'id');
        $pQuery=[];
        $pQuery['query'] = Product::find()->where(['in','goods_id',$product_goods_ids]);
        $pQuery['ids'] = $product_goods_ids;
        return  $pQuery;
    }

    public function doExport($prefix, $params)
    {
        $params['GoodsApiSearch'] = $params;
        $query = $this->getExportQuery($params);
        $count =  $query['query'] ? $query['query']->count() : 0;

        $title = [
            '货号Id','商品Id','商品编码','商品名称','二级分类',
            '三级分类', '品牌中文名', '品牌英文名', '货号','条形码',
            '规格','商品分佣比例(%)'
        ];
        $callback = function ($pageNum, $limit) use ($query) {
            echo $pageNum % 10 == 0 ? $pageNum . "\n" : $pageNum . "\t";
            $pageData = [];
            $mateData = $query['query']->limit($limit)->offset(($pageNum - 1) * $limit)->all();
            $goods = Goods::find()->select('goods.*,brand.name_en,brand.name_en,goods_commission.commission')->where(['in','goods.id',$query['ids']])->joinWith(['brand','goods_commission'])->asArray()->all();
            $good_value = ArrayHelper::index($goods,'id');
            $category = Category::find()->select('id,name')->asArray()->all();
            $category_value = ArrayHelper::index($category,'id');

            foreach ($mateData as $k => $model) {

                $line = [
                    $model->id,
                    $model->goods_id,
                    empty($good_value[$model->goods_id])?'': $good_value[$model->goods_id]['goods_code'],
                    empty($good_value[$model->goods_id])?'': $good_value[$model->goods_id]['name'],
                    ($good_value[$model->goods_id])['category_parent_id']=='0'?'': $category_value[$good_value[$model->goods_id]['category_parent_id']]['name'],
                    ($good_value[$model->goods_id])['category_id']=='0'?'': $category_value[$good_value[$model->goods_id]['category_id']]['name'],
                    empty($good_value[$model->goods_id])?'': $good_value[$model->goods_id]['brand']['name_cn'],
                    empty($good_value[$model->goods_id])?'': $good_value[$model->goods_id]['brand']['name_en'],
                    $model->product_bn,
                    $model->bar_code,
                    $model->spec_name,
                    empty($good_value[$model->goods_id])?'': $good_value[$model->goods_id]['goods_commission']['commission'],
                ];
                $pageData[] = $line;
            }
            return $pageData;
        };
//        try{
        $filename = StoreFileLib::saveToCsvFile($prefix, $count, 500, $title, $callback);
//        }catch (\Exception$e)
//        {
//            return [false, "saveToCsvFile error:".$e->getMessage()];
//        }

        return [true, $filename];
    }
}
