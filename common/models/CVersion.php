<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%c_version}}".
 *
 * @property int $id
 * @property string $version_code 版本号
 * @property string $download_url 下载地址
 * @property int $status 状态(0禁用,1使用)
 * @property string $description 描述
 * @property string $create_time 创建时间
 * @property int $type 系统类型（1：android   2:ios）
 * @property string $latestBuildCode 最新打包版本
 * @property string $versionMincode 最低支持版本
 * @property string $version_type 版本类型 
 */
class CVersion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%c_version}}';
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
            [['status', 'type'], 'integer'],
            [['description'], 'string'],
            [['create_time'], 'safe'],
            [['version_code'], 'string', 'max' => 11],
            [['download_url'], 'string', 'max' => 255],
            [['latestBuildCode', 'versionMincode'], 'string', 'max' => 20],
            [['version_type'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'version_code' => 'Version Code',
            'download_url' => 'Download Url',
            'status' => 'Status',
            'description' => 'Description',
            'create_time' => 'Create Time',
            'type' => 'Type',
            'latestBuildCode' => 'Latest Build Code',
            'versionMincode' => 'Version Mincode',
            'version_type' => 'Version Type',
        ];
    }
}
