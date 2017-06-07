<?php
namespace common\models;

/**
 * This is the model class for table "admin_log".
 *
 * @property integer $id
 * @property string $route
 * @property integer $ip
 * @property string $description
 * @property string $module
 * @property integer $created_at
 * @property integer $uid
 */
class AdminLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_system.admin_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['created_at'], 'required'],
            [['created_at', 'uid', 'ip'], 'integer'],
            [['module'], 'string', 'max' => 100],
            [['route'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'route' => '路由',
            'ip' => 'IP地址',
            'description' => '描述',
            'module' => '模块名称',
            'created_at' => '创建时间',
            'uid' => '用户ID',
        ];
    }

    public function getAdmin()
    {
        return $this->hasOne(Admin::className(),['id'=>'uid']);
    }
}
