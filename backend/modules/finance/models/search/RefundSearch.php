<?php

namespace backend\modules\finance\models\search;

use common\models\CUser;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\AfterSales;
use common\models\OrderObject;
use yii\helpers\ArrayHelper;
use console\libraries\StoreFileLib;

/**
 * RefundSearch represents the model behind the search form of `common\models\AfterSales`.
 */
class RefundSearch extends AfterSales
{
    public $user_name;
    public $order_object_bn;
    public $store_name;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'order_object_id', 'order_info_id', 'order_detail_id', 'user_id', 'product_id', 'quantity', 'refund_money', 'refund_cash_money', 'store_id', 'is_refund', 'type', 'send_back', 'platform_opinion', 'before_order_status', 'status', 'pay_type'], 'integer'],
            [['order_info_sn', 'product_bn', 'after_sn', 'user_refund_reason', 'user_first_reason', 'supplementary_reason', 'img_proof1', 'img_proof2', 'img_proof3', 'app_id','store_refuse_reason', 'store_refuse_reason1', 'courier_company', 'courier_company_en', 'courier_number', 'create_time', 'update_time', 'refund_id'], 'safe'],
            [['order_info_sn','product_bn','order_object_bn','user_name','store_name'],'trim']
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
       $query = AfterSales::find();
        $query->select('after_sales.*,order_object.order_sn,c_user.user_name')
            ->joinWith(['order_object','c_user'])
            ->where(['or','after_sales.status=2','after_sales.status=3'])
            ->orderBy(['after_sales.id'=>SORT_DESC]);

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
        $query
            ->andFilterWhere(['like', 'order_info_sn', $this->order_info_sn])
            ->andFilterWhere(['like', 'product_bn', $this->product_bn])
            ->andFilterWhere(['like', 'order_object.order_sn', $this->order_object_bn])
            ->andFilterWhere(['like', 'c_user.user_name', $this->user_name])
            ->andFilterWhere(['like', 'store.store_name', $this->store_name]);

        return $dataProvider;
    }

    public function doExport($prefix,$params)
    {
        $query = $this->getExportQuery($params);
        $count = $query?$query->count():0;
        $title = [
            'id', '父订单号', '支付方式', '状态', '商户理由',
            '售后类型','手机号码','子订单号','货号','用户退款理由',
            '用户首次填写的说明','退款金额','退款欧币','快递公司','快递单号'
        ];
        $callback = function($pageNum,$limit)use ($query){
            echo $pageNum%10 == 0 ? $pageNum."\n": $pageNum."\t";
            $pageData = [];
            $mateData = $query->limit($limit)->offset(($pageNum - 1) * $limit)->all();
            $objectIds = ArrayHelper::getColumn($mateData,'order_object_id');
            $orderObjectInfo = OrderObject::getOrderObjectByIds($objectIds);
            $userIds = ArrayHelper::getColumn($mateData,'user_id');
            $userInfo = CUser::getUserByIds($userIds);
            foreach ($mateData as $k => $model) {
                $line = [
                    '="' . $model->id . '"',
                    isset($orderObjectInfo[$model->order_object_id])?$orderObjectInfo[$model->order_object_id]['order_sn']:'',
                    AfterSales::dropDown('pay_type',$model->pay_type),
                    AfterSales::dropDown('status',$model->status),
                    $model->store_refuse_reason,

                    AfterSales::dropDown('is_refund',$model->is_refund),
                    '="' .isset($userInfo[$model->user_id])?$userInfo[$model->user_id]['user_name']:''. '"',
                    '="' . $model->order_info_sn. '"',
                    $model->product_bn,
                    $model->user_refund_reason,

                    $model->user_first_reason,
                    $model->refund_money/100,
                    $model->refund_cash_money,
                    $model->courier_company,
                    $model->courier_number,

                ];
                $pageData[] = $line;
            }
            return $pageData;
        };
        try{
            $filename = StoreFileLib::saveToCsvFile($prefix,$count,500,$title,$callback);
        }catch (\Exception $e){
            return [false, "saveToCsvFile:".$e->getMessage()];
        }
        return [true, $filename];

    }
    public function getExportQuery($params)
    {
        $query = AfterSales::find()
            ->where(['or','after_sales.status=2','after_sales.status=3'])
            ->orderBy(['after_sales.id'=>SORT_DESC]);
        $this->load($params);
        if($this->order_object_bn)
        {
            $order_obj_id = OrderObjectSearch::findIdBySn($this->order_object_bn);
            if($order_obj_id) {
                $query->andFilterWhere(["order_object_id" => $order_obj_id]);
            }else{
                return false;
            }
        }
        if($this->user_name)
        {
            $user = CUser::findOne(['user_name'=>$this->user_name]);
            if($user) {
                $query->andFilterWhere(["user_id" => $user->id]);
            }else{
                return false;
            }
        }

        // grid filtering conditions
        $query
            ->andFilterWhere(['like', 'order_info_sn', $this->order_info_sn])
            ->andFilterWhere(['like', 'product_bn', $this->product_bn])
//            ->andFilterWhere(['like', 'order_object.order_sn', $this->order_object_bn])
//            ->andFilterWhere(['like', 'c_user.user_name', $this->user_name])
//            ->andFilterWhere(['like', 'store.store_name', $this->store_name])
        ;

        return $query;
    }
}
