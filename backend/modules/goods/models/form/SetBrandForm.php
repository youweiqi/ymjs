<?php

namespace backend\modules\goods\models\form;


use Yii;
use yii\base\Model;


/**
 * RedeemCodeForm
 */
class SetBrandForm extends Model
{
    public $ids;
    public $brand_id;



    public function attributeLabels()
    {
        return [
             'ids'=>'IDS',
            'brand_id' => '品牌',

        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['brand_id'], 'required'],
            [['brand_id'], 'integer'],
            ['ids','safe']
        ];
    }

}
