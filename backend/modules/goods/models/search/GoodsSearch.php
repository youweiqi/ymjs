<?php

namespace backend\modules\goods\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Goods;

/**
 * GoodsSearch represents the model behind the search form of `common\models\Goods`.
 */
class GoodsSearch extends Goods
{
    public $brand_name;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'brand_id', 'suggested_price', 'lowest_price', 'category_parent_id', 'category_id', 'talent_limit', 'threshold', 'ascription', 'talent_display', 'discount', 'operate_costing', 'score_rate', 'self_support', 'channel', 'api_goods_id'], 'integer'],
            [['brand_name','name_cn','name_en','goods_code', 'name', 'spec_desc', 'service_desc', 'label_name', 'unit', 'remark', 'online_time', 'offline_time', 'create_time', 'wx_small_imgpath'], 'safe'],
            [['id','brand_name','goods_code','name'],'trim']
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
            ->joinWith(['brand'])
            ->orderBy(['goods.id'=>SORT_DESC]);//根据需要去默认排序（表.字段）

        // add conditions that should always apply here
        $pageSize = isset($params['per-page']) ? intval($params['per-page']) : 20;
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
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
}
