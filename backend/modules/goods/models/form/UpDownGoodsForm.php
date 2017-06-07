<?php

namespace backend\modules\goods\models\form;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class UpDownGoodsForm extends Model
{
    public $online_time;
    public $offline_time;
    public $ids;

    public function attributeLabels()
    {
        return [
            'online_time' => '上架时间',
            'offline_time' => '下架时间',
            'ids'=>'ID'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['ids','online_time','offline_time'],'safe']
        ];
    }
}
