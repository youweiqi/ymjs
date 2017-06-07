<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "share_activity".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $activity_id
 * @property string $create_time
 */
class ShareActivity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_goods.share_activity';
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
            [['user_id', 'activity_id'], 'integer'],
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
            'user_id' => '商户通用户id',
            'activity_id' => '活动id',
            'create_time' => '创建时间',
        ];
    }
}
