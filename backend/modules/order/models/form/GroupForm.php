<?php

namespace backend\modules\order\models\form;

use common\models\TeamUserRelation;
use Yii;
use yii\base\Model;

class GroupForm extends Model
{
    public $ids;

    public function attributeLabels()
    {
        return [
            'team_name' => '确认小组',
            'user_name' => '确认人',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ids'], 'safe'],
        ];
    }

}

