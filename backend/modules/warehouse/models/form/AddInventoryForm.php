<?php

namespace backend\modules\warehouse\models\form;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
    class AddInventoryForm extends Model
{
        public $inventory_num;
        public $ids;



    public function attributeLabels()
    {
        return [
            'inventory_num' => '库存数量',
            'ids'=>'ID'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['inventory_num'], 'required'],
            ['inventory_num','integer'],
            ['ids','safe']
        ];
    }
}
