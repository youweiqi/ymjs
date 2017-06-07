<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "group_buying".
 *
 * @property integer $id
 * @property integer $activity_id
 * @property integer $user_id
 * @property integer $num
 * @property integer $status
 * @property string $create_time
 */
class GroupBuying extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_goods.group_buying';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_goods');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['activity_id', 'user_id', 'num', 'status'], 'integer'],
            [['create_time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'activity_id' => '活动id',
            'user_id' => '开团人id',
            'num' => '参团人数',
            'status' => '拼团状态0禁用1拼团中2成功3失败',
            'create_time' => '开团时间',
        ];
    }
}
