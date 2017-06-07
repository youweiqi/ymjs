<?php

namespace backend\modules\thirdparty\models\form;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class NumForm extends Model
{
    public $num;

    public function attributeLabels()
    {
        return [
            'num'=>'页'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['num'],'integer']
        ];
    }
}
