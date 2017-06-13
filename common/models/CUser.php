<?php

namespace common\models;

use common\models\UserCommission;
use Yii;
use yii\helpers\ArrayHelper;


/**
 * This is the model class for table "{{%c_user}}".
 *
 * @property int $id
 * @property string $user_name 登陆用户名
 * @property string $password 登录密码
 * @property int $role_id 角色
 * @property int $old_role_id 原角色
 * @property string $background_image 达人主页背景图
 * @property string $nick_name 昵称
 * @property string $picture 头像
 * @property int $lock_status 1锁定 0未锁定
 * @property int $is_black 是否黑名单(1：是 0：否)
 * @property int $money 账号余额
 * @property string $synopsis 个人介绍
 * @property string $talent_effect_time 达人生效时间
 * @property string $talent_failure_time 达人失效时间
 * @property int $empiric_value 经验值
 * @property int $total_cost 累计消费金额
 * @property int $total_sale 达人累计销售额
 * @property string $recommend_from 普通推荐人身份id
 * @property string $member_recommend 会员推荐人
 * @property string $talent_teacher 达人导师/经纪人身份id
 * @property string $last_login_time 最后登陆时间
 * @property string $create_time 创建时间
 * @property string $update_time 修改时间
 * @property int $fans_count 粉丝数
 * @property int $remain_sales_quota 升级剩余所需销售额度
 * @property string $remark 备注
 * @property int $total_cost_score 累计消费积分
 * @property int $parent_user_id 累计消费积分

 *
 */
class CUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_user.c_user';
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
            ['talent_effect_time','required'],
            [['parent_user_id','root_user_id','role_id', 'old_role_id', 'lock_status', 'is_black', 'money', 'empiric_value', 'total_cost', 'total_sale', 'fans_count', 'remain_sales_quota', 'total_cost_score'], 'integer'],
            [['synopsis'], 'string'],
            [['talent_effect_time', 'talent_failure_time', 'last_login_time', 'create_time', 'update_time'], 'safe'],
            [['user_name'], 'string', 'max' => 11],
            [['password'], 'string', 'max' => 255],
            [['background_image', 'picture'], 'string', 'max' => 300],
            [['nick_name'], 'string', 'max' => 30],
            [['recommend_from', 'member_recommend', 'talent_teacher'], 'string', 'max' => 20],
            [['remark'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_name' => '手机号码',
            'password' => 'Password',
            'role_id' => '角色',
            'old_role_id' => 'Old Role ID',
            'background_image' => 'Background Image',
            'nick_name' => '昵称',
            'picture' => 'Picture',
            'lock_status' => '锁定状态',
            'is_black' => 'Is Black',
            'money' => '欧币',
            'synopsis' => 'Synopsis',
            'talent_effect_time' => '会员生效时间',
            'talent_failure_time' => '会员失效时间',
            'empiric_value' => '经验值',
            'total_cost' => 'Total Cost',
            'total_sale' => 'Total Sale',
            'recommend_from' => 'Recommend From',
            'member_recommend' => 'Member Recommend',
            'talent_teacher' => 'Talent Teacher',
            'last_login_time' => 'Last Login Time',
            'create_time' => '注册时间',
            'update_time' => 'Update Time',
            'fans_count' => 'Fans Count',
            'remain_sales_quota' => 'Remain Sales Quota',
            'remark' => 'Remark',
            'total_cost_score' => 'Total Cost Score',
            'parent_user_id' => '上级分销商',
            'root_user_id' => '总分销商'
        ];
    }

    public static function dropDown($column, $value = null){
        $dropDownList = [

            'lock_status'=> [
                '0'=>'未锁定',
                '1'=>'已锁定',
            ],
        ];
        if ($value !== null){
            return array_key_exists($column, $dropDownList) ? $dropDownList[$column][$value] : false;
        }else{
            return array_key_exists($column, $dropDownList) ? $dropDownList[$column] : false;
        }
    }

    public function getC_role(){
        return $this->hasOne(CRole::className(),['id'=>'role_id']);
    }
    public static function getNickName($user_id){
        $user_info = self::findOne($user_id);
        if(empty($user_info)){
            return $user_id;
        }
        return $user_info->user_name;
    }
    public static function getUserByIds($ids)
    {
        $result = self::find()->where(['in','id',$ids])->asArray()->all();
        return empty($result)?[]:ArrayHelper::index($result,'id');
    }

    public function getUser_commission(){
        $model = $this->hasOne(UserCommission::className(),['user_id'=>'id'])->one();
        if($model) {
            return $model;
        }else{
            return (new UserCommission());
        }
    }
}
