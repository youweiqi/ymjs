<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "goods_comment".
 *
 * @property integer $id
 * @property integer $good_id
 * @property integer $user_id
 * @property integer $order_detail_id
 * @property string $comment_text
 * @property string $spec_name
 * @property string $image1
 * @property string $image2
 * @property string $image3
 * @property string $create_time
 * @property integer $status
 */
class GoodsComment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_goods.goods_comment';
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
            [['good_id', 'user_id', 'order_detail_id', 'status'], 'integer'],
            [['comment_text'], 'string'],
            [['create_time'], 'safe'],
            [['spec_name', 'image1', 'image2', 'image3'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'good_id' => '商品',
            'user_id' => '用户',
            'order_detail_id' => '订单明细',
            'comment_text' => '评论内容',
            'spec_name' => '商品规格名称组合',
            'image1' => '图片1',
            'image2' => '图片2',
            'image3' => '图片3',
            'create_time' => '创建时间',
            'status' => '状态',
        ];
    }

    public static function dropDown($column, $value = null){
        $dropDownList = [
            'status'=> [
                '0'=>'禁用',
                '1'=>'启用',
            ],
        ];
        if ($value !== null){
            return array_key_exists($column, $dropDownList) ? $dropDownList[$column][$value] : false;
        }else{
            return array_key_exists($column, $dropDownList) ? $dropDownList[$column] : false;
        }
    }
    public function getC_user()
    {
        return $this->hasOne(CUser::className(),['id'=>'user_id']);
    }
    public function getGoods()
    {
        return $this->hasOne(Goods::className(),['id'=>'good_id']);
    }
}
