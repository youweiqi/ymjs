<?php

namespace backend\modules\content\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\SerialContent;

/**
 * SerialContentSearch represents the model behind the search form of `common\models\SerialContent`.
 */
class SerialContentSearch extends SerialContent
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'serial_id', 'order_no', 'jump_style', 'img_width', 'img_height'], 'integer'],
            [['image_path', 'jump_to'], 'safe'],
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
        $query = SerialContent::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'serial_id' => $this->serial_id,
            'order_no' => $this->order_no,
            'jump_style' => $this->jump_style,
            'img_width' => $this->img_width,
            'img_height' => $this->img_height,
        ]);

        $query->andFilterWhere(['like', 'image_path', $this->image_path])
            ->andFilterWhere(['like', 'jump_to', $this->jump_to]);

        return $dataProvider;
    }
}
