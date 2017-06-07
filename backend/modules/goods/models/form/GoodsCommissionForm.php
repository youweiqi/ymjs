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
    public $score_rate;
    public $talent_limit;



    public function attributeLabels()
    {
        return [
            'ids' => '商品ID',
            'score_rate' => '返欧币比例(%)',
            'talent_limit' => '会员佣金比例(%)',

        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['score_rate','talent_limit',], 'required'],
            [['score_rate','talent_limit',], 'integer'],
            [['talent_limit','score_rate'],'compare','compareValue' => 100, 'operator' => '<='],
            [['talent_limit','score_rate'],'compare','compareValue' => 0, 'operator' => '>='],
            ['ids','safe']
        ];
    }

}
