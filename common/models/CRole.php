<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%c_role}}".
 *
 * @property int $id
 * @property string $role_name 角色名
 * @property string $role_code 角色编码
 * @property int $level 级别
 * @property int $role_type 角色类型(0:用户角色1:推荐角色)
 * @property string $create_time 创建时间
 */
class CRole extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_user.c_role';
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
            [['level', 'role_type'], 'integer'],
            [['create_time'], 'safe'],
            [['role_name'], 'string', 'max' => 10],
            [['role_code'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'role_name' => 'Role Name',
            'role_code' => 'Role Code',
            'level' => 'Level',
            'role_type' => 'Role Type',
            'create_time' => 'Create Time',
        ];
    }
}
