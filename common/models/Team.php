<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%team}}".
 *
 * @property int $id
 * @property string $team_name
 */
class Team extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{yg_system.team}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['team_name'], 'required'],
            [['id'], 'integer'],
            [['team_name'], 'string', 'max' => 64],
            [['id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'team_name' => '小组名称',
        ];
    }
}
