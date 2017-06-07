<?php

namespace backend\modules\thirdparty\models\form;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class AddApiGoodsForm extends Model
{
    public $ids;

    public function attributeLabels()
    {
        return [
            'ids'=>'ID'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['ids'],'safe']
        ];
    }
}
