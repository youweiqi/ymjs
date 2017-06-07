<?php

namespace backend\modules\warehouse\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\StoreRefundAddress;

/**
 * StoreRefundAddressSearch represents the model behind the search form of `common\models\StoreRefundAddress`.
 */
class StoreRefundAddressSearch extends StoreRefundAddress
{
    public $store_name;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'store_id', 'status'], 'integer'],
            [['link_man', 'mobile', 'province', 'city', 'area', 'address', 'create_time', 'update_time'], 'safe'],
            [['id','link_man','store_name'],'trim']
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
        $query = StoreRefundAddress::find()
            ->select('store_refund_address.*,store.store_name')
            ->joinWith(['store'])
            ->orderBy(['store_refund_address.id'=>SORT_DESC]);//根据需要去默认排序（表.字段）;;

        // add conditions that should always apply here

        $pageSize = isset($params['per-page']) ? intval($params['per-page']) : 20;
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'store_refund_address.id' => $this->id,
            'store_refund_address.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'link_man', $this->link_man])
            ->andFilterWhere(['like', 'store.store_name', $this->store_name]);

        return $dataProvider;
    }
}
