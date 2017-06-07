<?php

namespace backend\modules\goods\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Brand;

/**
 * BrandSearch represents the model behind the search form of `common\models\Brand`.
 */
class BrandSearch extends Brand
{
    public $brand_name;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'like_count', 'status'], 'integer'],
            [['first_char', 'name_cn', 'name_en', 'descriptions', 'logo_path', 'background_image_path', 'order_no'], 'safe'],
            [['id','brand_name','first_char',],'trim']
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
        $query = Brand::find();

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
            'id' => $this->id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'first_char', $this->first_char])
                ->andFilterWhere([
                'or',
                ['like', 'brand.name_cn', $this->brand_name],
                ['like', 'brand.name_en', $this->brand_name],
                 ]);

        return $dataProvider;
    }
}
