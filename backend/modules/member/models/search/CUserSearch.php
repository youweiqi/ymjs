<?php

namespace backend\modules\member\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\CUser;

/**
 * CUserSearch represents the model behind the search form of `common\models\CUser`.
 */
class CUserSearch extends CUser
{
    public $begin_time;
    public $end_time;
    public $user_name;
    public $root_user_name;
    public $parent_user_name;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'role_id', 'old_role_id', 'lock_status', 'is_black', 'money', 'empiric_value', 'total_cost', 'total_sale', 'fans_count', 'remain_sales_quota', 'total_cost_score'], 'integer'],
            [['begin_time','end_time','user_name', 'password', 'background_image', 'nick_name', 'picture', 'synopsis', 'talent_effect_time', 'talent_failure_time', 'recommend_from', 'member_recommend', 'talent_teacher', 'last_login_time', 'create_time', 'update_time', 'remark'], 'safe'],
            [['user_name','root_user_name','parent_user_name'],'trim']
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
        $query = CUser::find()
            ->select('c_user.*,c_role.role_name')
            ->joinWith(['c_role'])
            ->orderBy(['c_user.id'=>SORT_DESC]);//根据需要去默认排序（表.字段）;

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        if(isset($params['CUserSearch'])) {
            $param['root_user_name'] = $params['CUserSearch']['root_user_name'];
            if (!empty($param['root_user_name'])) {
                $model1 = self::findOne(['user_name' => $param['root_user_name']]);
                if (is_object($model1)) {
                    $user_id = $model1->id;
                    $query->andFilterWhere(['=', 'root_user_id', $user_id]);
                } else {
                    $query->andWhere(['=', 'root_user_id', null]);
                }

            }

            $param['parent_user_name'] = $params['CUserSearch']['parent_user_name'];
            if (!empty($param['parent_user_name'])) {
                $model2 = self::findOne(['user_name' => $param['parent_user_name']]);
                if (is_object($model2)) {
                    $user_id = $model2->id;
                    $query->andFilterWhere(['=', 'parent_user_id', $user_id]);
                } else {
                    $query->andWhere(['=', 'parent_user_id', null]);
                }

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
            'c_user.id' => $this->id,
            'role_id' => $this->role_id,
            'old_role_id' => $this->old_role_id,
            'lock_status' => $this->lock_status,
            'is_black' => $this->is_black,
            'money' => $this->money,
            'talent_effect_time' => $this->talent_effect_time,
            'talent_failure_time' => $this->talent_failure_time,
            'empiric_value' => $this->empiric_value,
            'total_cost' => $this->total_cost,
            'total_sale' => $this->total_sale,
            'last_login_time' => $this->last_login_time,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
            'fans_count' => $this->fans_count,
            'remain_sales_quota' => $this->remain_sales_quota,
            'total_cost_score' => $this->total_cost_score,
        ]);

        $query->andFilterWhere(['like', 'c_user.user_name', $this->user_name])
            ->andFilterWhere(['between','c_user.create_time',$this->begin_time,$this->end_time]);


        return $dataProvider;
    }
    public static function getUidByUserName($user_name)
    {
        $user_info = self::findOne(['user_name'=>$user_name]);
        if($user_info)
        {
            return $user_info->id;
        }else{
            return false;
        }
    }
}
