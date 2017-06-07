<?php

namespace backend\modules\order\models\form;

use Yii;
use yii\base\Model;

class DeliveryForm extends Model
{
    public $order_id;
    public $order_sn;
    public $express_name;
    public $express_no;
    public $link_man;

    public function attributeLabels()
    {
        return [
            'order_id' => '订单ID',
            'order_sn' => '订单号',
            'express_name' => '物流公司名称',
            'express_no' => '快递单号',
            'link_man' =>'收货人'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_sn','express_name','express_no'], 'required'],
            [['order_id','link_man'], 'safe'],
        ];
    }
}

