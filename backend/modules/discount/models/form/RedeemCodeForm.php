<?php

namespace backend\modules\discount\models\form;


use Yii;
use yii\base\Model;


/**
 * RedeemCodeForm
 */
class RedeemCodeForm extends Model
{
    public $create_quantity;
    public $usable_times;
    public $start_date;
    public $end_date;
    public $promotion_id;
    public $remark;


    public function attributeLabels()
    {
        return [
            'create_quantity' => '生成数量',
            'remark'=>'备注',
            'usable_times' => '可用次数',
            'start_date' => '开始时间',
            'end_date' => '结束时间',
            'promotion_id' => '优惠礼包名称',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['create_quantity','usable_times','start_date','end_date','promotion_id'], 'required'],
            ['create_quantity', 'compare', 'compareValue' => 5000, 'operator' => '<='],
            [['create_quantity','usable_times','promotion_id'], 'integer'],
            ['remark','string', 'max' => 255]
        ];
    }

}
