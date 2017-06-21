<?php

namespace backend\modules\order\models\search;

use backend\modules\finance\models\search\OrderObjectSearch;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\OrderDetail;
use backend\modules\member\models\search\CUserSearch;
use common\models\OrderObject;
use common\models\CUser;
use common\models\OrderInfo;
use common\models\Product;
use console\libraries\StoreFileLib;
/**
 * OrderDetailSearch represents the model behind the search form of `common\models\OrderDetail`.
 */
class OrderDetailSearch extends OrderDetail
{
    public $order_sn;
    public $order_object_order_sn;
    public $order_link_man;
    public $order_store_name;
    public $order_status;
    public $order_user_name;
    public $order_mobile;
    public $order_refund;
    public $other;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'order_id', 'order_object_id', 'user_id', 'brand_id', 'good_id', 'product_id', 'store_id', 'inventory_id', 'channel', 'product_price', 'sale_price', 'settlement_price', 'cooperate_price', 'quantity', 'total_price', 'total_settlementprice', 'total_cooperate_price', 'total_fee', 'cash_coin', 'promotion_discount', 'talent_serial_id', 'talent_share_good_id', 'talent_serial_editandshare_id', 'share_serial_id', 'share_activity_id', 'talent_id', 'discount', 'talent_agio', 'applywelfare_id', 'activity_type', 'group_buying_id', 'status', 'refund', 'comment_status', 'type', 'app_id', 'mall_store_id'], 'integer'],
            [['order_sn','order_refund','order_mobile','order_object_order_sn','order_link_man','order_store_name','order_status','order_user_name','other','brand_name', 'good_name', 'label_name', 'spec_name', 'navigate_img1', 'create_time', 'update_time'], 'safe'],
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
        $query = OrderDetail::find();

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
            'order_id' => $this->order_id,
            'order_object_id' => $this->order_object_id,
            'user_id' => $this->user_id,
            'brand_id' => $this->brand_id,
            'good_id' => $this->good_id,
            'product_id' => $this->product_id,
            'store_id' => $this->store_id,
            'inventory_id' => $this->inventory_id,
            'channel' => $this->channel,
            'product_price' => $this->product_price,
            'sale_price' => $this->sale_price,
            'settlement_price' => $this->settlement_price,
            'cooperate_price' => $this->cooperate_price,
            'quantity' => $this->quantity,
            'total_price' => $this->total_price,
            'total_settlementprice' => $this->total_settlementprice,
            'total_cooperate_price' => $this->total_cooperate_price,
            'total_fee' => $this->total_fee,
            'cash_coin' => $this->cash_coin,
            'promotion_discount' => $this->promotion_discount,
            'talent_serial_id' => $this->talent_serial_id,
            'talent_share_good_id' => $this->talent_share_good_id,
            'talent_serial_editandshare_id' => $this->talent_serial_editandshare_id,
            'share_serial_id' => $this->share_serial_id,
            'share_activity_id' => $this->share_activity_id,
            'talent_id' => $this->talent_id,
            'discount' => $this->discount,
            'talent_agio' => $this->talent_agio,
            'applywelfare_id' => $this->applywelfare_id,
            'activity_type' => $this->activity_type,
            'group_buying_id' => $this->group_buying_id,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
            'status' => $this->status,
            'refund' => $this->refund,
            'comment_status' => $this->comment_status,
            'type' => $this->type,
            'app_id' => $this->app_id,
            'mall_store_id' => $this->mall_store_id,
        ]);

        $query->andFilterWhere(['like', 'brand_name', $this->brand_name])
            ->andFilterWhere(['like', 'good_name', $this->good_name])
            ->andFilterWhere(['like', 'label_name', $this->label_name])
            ->andFilterWhere(['like', 'spec_name', $this->spec_name])
            ->andFilterWhere(['like', 'navigate_img1', $this->navigate_img1]);

        return $dataProvider;
    }
    public function exportSearch($params)
    {
        $query = OrderDetail::find()
            ->joinWith(['order_info','order_object','c_user'])
            ->orderBy(['order_detail.id'=>SORT_ASC]);

        // add conditions that should always apply here

        $exportDataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $param = [];
        if(isset($params['OrderInfoSearch'])){

            $param['order_sn'] = $params['OrderInfoSearch']['order_sn'];
            $param['order_status'] = $params['OrderInfoSearch']['status'];
            $param['order_store_name'] = $params['OrderInfoSearch']['store_name'];
            $param['order_link_man'] = $params['OrderInfoSearch']['link_man'];
            $param['order_object_order_sn'] = $params['OrderInfoSearch']['order_object_bn'];
            $param['order_user_name'] = $params['OrderInfoSearch']['user_name'];

        }
        $params['OrderDetailSearch'] = $param;

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $exportDataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'order_info.status' => $this->order_status,
        ]);

        $query
            ->andFilterWhere(['like', 'order_info.order_sn', $this->order_sn])
            ->andFilterWhere(['like', 'order_info.link_man', $this->order_link_man])
            ->andFilterWhere(['like', 'c_user.user_name', $this->order_user_name])
            ->andFilterWhere(['like', 'order_object.order_sn', $this->order_object_order_sn])
            ->andFilterWhere(['like', 'order_info.store_name', $this->order_store_name]);

//        echo $query->createCommand()->getRawSql();exit;
        return $exportDataProvider;
    }

    public function doExport($prefix,$params)
    {
        $param['order_sn'] = $params['order_sn'];
        $param['order_mobile'] = $params['mobile'];
        $param['order_refund'] = $params['refund'];
        $param['order_status'] = $params['status'];
        $param['order_store_name'] = $params['store_name'];
        $param['order_link_man'] = $params['link_man'];
        $param['order_object_order_sn'] = $params['order_object_bn'];
        $param['order_user_name'] = $params['user_name'];
        $params['OrderDetailSearch'] = $param;

        $query = $this->getExportQuery($params);
        $count = $query?$query->count():0;
        $title = [
            '订单号', '父订单号', '会员', '门店', '收货人',
            '收货人手机号', '省', '市', '县','街道',
            '地址','快递费','支付方式','实际售价','实际支付金额',
            '付款时间','商品名称','货号','规格','商品数量',
            '当前售价','商品价格(没有任何优惠的价格)','当前结算价','总结算成本价', '订单状态',
            '是否开票', '发票类型', '发票抬头','配送方式', '快递公司',
            '快递单号','订单创建时间', '订单更新时间','订单备注'
        ];
        $callback = function($pageNum,$limit)use ($query){
            echo $pageNum%10 == 0 ? $pageNum."\n": $pageNum."\t";
            $pageData = [];
            $mateData = $query->limit($limit)->offset(($pageNum - 1) * $limit)->all();
            foreach ($mateData as $k => $model) {
                $line = [
                    '="' . $model->order_info->order_sn . '"',
                    OrderObject::getObject_sn($model->order_object_id),
                    '="' . CUser::getNickName($model->order_info->user_id) . '"',
                    $model->order_info->store_name,
                    $model->order_info->link_man,
                    '="' . $model->order_info->mobile . '"',
                    $model->order_info->province,
                    $model->order_info->city,
                    $model->order_info->area,
                    $model->order_info->street,
                    $model->order_info->address,
                    $model->order_info->freight ? $model->order_info->freight / 100 : '0',
                    OrderInfo::dropDown('pay_type', $model->order_info->pay_type),
                    $model->order_info->total_price ? $model->order_info->total_price / 100 : '0',
                    $model->order_info->total_fee ? $model->order_info->total_fee / 100 : '0',
                    $model->order_info->pay_time,
                    $model->good_name,
                    $model->product_id ? Product::getProductBnById($model->product_id) : "",
                    $model->spec_name,
                    $model->quantity,
                    $model->sale_price ? $model->sale_price / 100 : '0',
                    $model->product_price ? $model->product_price / 100 : '0',
                    $model->settlement_price ? $model->settlement_price / 100 : '0',
                    $model->total_settlementprice ? $model->total_settlementprice / 100 : '0',
                    OrderInfo::dropDown('status', $model->order_info->status),
                    OrderInfo::dropDown('is_bill', $model->order_info->is_bill),
                    OrderInfo::dropDown('bill_type', $model->order_info->bill_type),
                    OrderInfo::dropDown('bill_header', $model->order_info->bill_header),
                    OrderInfo::dropDown('delivery_way', $model->order_info->delivery_way),
                    $model->order_info->express_name,
                    '="' . $model->order_info->express_no . '"',
                    $model->order_info->create_time,
                    $model->order_info->update_time,
                    $model->order_info->remark
                ];
                $pageData[] = $line;
            }
            return $pageData;
        };
        try{
            $filename = StoreFileLib::saveToCsvFile($prefix,$count,500,$title,$callback);
        }catch (\Exception $e){
            echo 'Error'.$e->getMessage()."\n";
            return [false, "saveToCsvFile:".$e->getMessage()];
        }
        return [true, $filename];
    }


    private function getExportQuery($params)
    {
        $this->load($params);
        $query = OrderDetail::find()
            ->joinWith('order_info')
            ->orderBy(['order_detail.id'=>SORT_ASC]);
        if($this->order_user_name) //如果有会员条件
        {
            $uid = CUserSearch::getUidByUserName($this->order_user_name);
            if ($uid)
            {
                $query->andFilterWhere(["order_detail.user_id" => $uid]);
            }else{
                return false;
            }
        }
        if($this->order_object_order_sn) //如果有order_sn条件
        {
            $order_obj_id = OrderObjectSearch::findIdBySn($this->order_object_order_sn);
            if($order_obj_id) {
                $query->andFilterWhere(["order_detail.order_object_id" => $order_obj_id]);
            }else{
                return false;
            }
        }
        $query->andFilterWhere([
            'order_info.status' => $this->order_status,
            'order_info.refund' => $this->order_refund,
        ]);
        $query
            ->andFilterWhere(['like', 'order_info.order_sn', $this->order_sn])
            ->andFilterWhere(['like', 'order_info.link_man', $this->order_link_man])
            ->andFilterWhere(['like', 'order_info.mobile', $this->order_mobile])
            ->andFilterWhere(['like', 'order_info.store_name', $this->order_store_name]);

        return $query;
    }
}
