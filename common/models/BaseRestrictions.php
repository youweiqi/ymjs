<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%base_restrictions}}".
 *
 * @property int $id
 * @property int $restrictions 限制
 * @property string $name 名称
 * @property int $experience 发放经验值数
 * @property int $status 0禁用1使用
 * @property string $create_time 创建时间
 * @property string $update_time 修改时间
 */
class BaseRestrictions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%base_restrictions}}';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_user');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['restrictions', 'experience', 'status'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['name'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'restrictions' => 'Restrictions',
            'name' => 'Name',
            'experience' => 'Experience',
            'status' => 'Status',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
