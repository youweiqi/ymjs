<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%talent_job}}".
 *
 * @property int $id
 * @property string $job_no 讲师编号
 * @property string $leader 讲师所在队伍ID
 * @property string $leader_name 	讲师所在队伍名称
 * @property string $name 讲师姓名
 * @property string $password 讲师密码
 * @property string $branch_id 讲师所属分公司ID
 * @property string $branch_name 讲师所属分公司名称
 * @property int $dimission 	是否为离职状态： 1: 在职 ， false ：0
 * @property int $user_id 用户id
 */
class TalentJob extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%talent_job}}';
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
            [['dimission', 'user_id'], 'integer'],
            [['job_no', 'leader', 'leader_name', 'name', 'password', 'branch_id', 'branch_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'job_no' => 'Job No',
            'leader' => 'Leader',
            'leader_name' => 'Leader Name',
            'name' => 'Name',
            'password' => 'Password',
            'branch_id' => 'Branch ID',
            'branch_name' => 'Branch Name',
            'dimission' => 'Dimission',
            'user_id' => 'User ID',
        ];
    }
}
