<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%team_user_relation}}".
 *
 * @property int $id
 * @property int $team_id
 * @property int $user_id
 */
class TeamUserRelation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{yg_system.team_user_relation}}';
    }
    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['team_id', 'user_id'], 'required'],
            ['team_id', 'integer'],
            ['user_id','safe','on' => 'create'],
            [['id'], 'unique'],

        ];
    }

    public function scenarios()
    {
       return[
           'create' => ['team_id','user_id'],
           'update' => ['team_id','user_id']
       ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'team_id' => '确认小组',
            'user_id' => '小组成员',
        ];
    }

    public function getTeam(){
        return $this->hasOne(Team::className(),['id'=>'team_id']);
    }

    public function getUser(){
        return $this->hasOne(User::className(),['uid'=>'user_id']);
    }



}
