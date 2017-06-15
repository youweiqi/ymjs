<?php

namespace backend\modules\goods\models\form;


use Yii;
use yii\base\Model;


/**
 * RedeemCodeForm
 */
class GoodsCommissionForm extends Model
{
    public $ids;
    public $commission;



    public function attributeLabels()
    {
        return [
            'ids' => '商品ID',
            'commission' => '商品分佣(%)',

        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['commission', 'required'],
            ['commission', 'integer'],
            ['commission','compare','compareValue' => 100, 'operator' => '<='],
            ['commission','compare','compareValue' => 0, 'operator' => '>='],
            ['ids','safe']
        ];
    }

}
