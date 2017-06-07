<?php

namespace backend\modules\warehouse\models\search;

use common\models\Brand;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Store;

/**
 * StoreSearch represents the model behind the search form of `common\models\Store`.
 */
class StoreSearch extends Store
{
    public $brand_name;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'supplier_id', 'money', 'settlement_interval', 'open_flash_express', 'open_install', 'open_express', 'store_type', 'is_show_commit', 'is_show_map', 'is_modify_inventory', 'checkout_type', 'commisionlimit', 'price_no_freight', 'cooperate_type', 'agent_user_id', 'agent_user_id3', 'agent_user_id6', 'commision_target', 'sale_target', 'status'], 'integer'],
            [['store_name', 'logo_path', 'back_image_path', 'province', 'city', 'area', 'address', 'settlement_account', 'settlement_bank', 'settlement_man', 'flash_express_begin_time', 'flash_express_end_time', 'install_begin_time', 'install_end_time', 'tel', 'channel', 'create_time', 'update_time', 'qr_code'], 'safe'],
            [['lon', 'lat', 'distance'], 'number'],
            [['id','store_name','brand_name'],'trim']
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
        $query = Store::find()
            ->select('store.*,brand.name_cn,brand.name_en,')
            ->joinWith(['brand'])
            ->orderBy(['store.id'=>SORT_DESC]);//根据需要去默认排序（表.字段）
        ;

        // add conditions that should always apply here

        $pageSize = isset($params['per-page']) ? intval($params['per-page']) : 20;
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' =>  ['pageSize' => $pageSize,],
        ]);

        $brand_data = [];

        if(isset($params['StoreSearch'])) {

            $brand_ids = Brand::find()->select('id')->where([
                'or',
                ['like', 'brand.name_cn', $params['StoreSearch']['brand_name']],
                ['like', 'brand.name_en', $params['StoreSearch']['brand_name']],

            ])->asArray()->all();

            foreach ($brand_ids as $brand_id)
            {
                $brand_data[] = $brand_id['id'];
            }
        }

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,

        ]);

        $query->andFilterWhere(['like', 'store_name', $this->store_name])
              ->andFilterWhere(['in','store_brand.brand_id',$brand_data]);


        return $dataProvider;
    }
}
