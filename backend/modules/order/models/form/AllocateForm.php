<?php

namespace backend\modules\order\models\form;

use common\models\TeamUserRelation;
use Yii;
use yii\base\Model;

class AllocateForm extends Model
{
    public $team_name;
    public $user_name;
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
            ['team_name', 'needFind'],
            [['user_name','ids'], 'safe'],
        ];
    }
    public function needFind($attribute, $params)
    {
        if(!empty($this->user_name)){
            $allocate =  TeamUserRelation::find()->where(['and',['=','team_id',$this->$attribute],['=','user_id',$this->user_name]])->one();
            if(!is_object($allocate)){
                $this->addError($attribute,'当前确认小组没有该确认人');
            }
        }
    }
}

