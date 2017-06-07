<?php

namespace backend\modules\finance\models\form;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class UserJournalForm extends Model
{
    public $ids;
    public $status;

    public function attributeLabels()
    {
        return [
            'ids'=>'ID',
            'status'=>'状态'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ids','status'],'safe']
        ];
    }
}
