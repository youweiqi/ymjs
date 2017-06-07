<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "brand".
 *
 * @property integer $id
 * @property string $first_char
 * @property string $name_cn
 * @property string $name_en
 * @property string $descriptions
 * @property string $logo_path
 * @property string $background_image_path
 * @property integer $like_count
 * @property integer $status
 * @property string $order_no
 */
class Brand extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yg_goods.brand';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_goods');
    }
    public function attributes()
    {
        $attributes = ['brand_name','parent_ids'];
        return array_merge(parent::attributes(),$attributes);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['like_count', 'status'], 'integer'],
            [['first_char', 'order_no'], 'string', 'max' => 11],
            [['name_cn'], 'string', 'max' => 20],
            [['name_en'], 'string', 'max' => 50],
            [['descriptions', 'logo_path', 'background_image_path'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_char' => '品牌首字母',
            'name_cn' => '中文名',
            'name_en' => '英文名',
            'descriptions' => '简述',
            'logo_path' => 'logo图片地址',
            'background_image_path' => '背景图片地址',
            'like_count' => '喜欢人数',
            'status' => '状态',
            'order_no' => '排序字段（本期用不到该字段，暂时保留，下次使用该字段，请修改这个注释）',
        ];
    }

    public static function dropDown($column,$value=null)
    {
        $dropDownList=[
            'status'=>[
                '0'=>'禁用',
                '1'=>'正常',
            ]
        ];
        if ($value!==null){
            return array_key_exists($column,$dropDownList)? $dropDownList[$column][$value]:false;
        }else{
            return array_key_exists($column,$dropDownList)? $dropDownList[$column]:false;
        }
    }


    public function requiredByOne($attribute, $params){
        if ($this->name_cn =="" && $this->name_en =="") {
            $this->addError($attribute, "2个品牌名至少需要填一个");}
    }
    //验证first_char 必须是大写的字母
    public function check($attribute,$params){
        if(!in_array($this->first_char,array('Q','W','E','R','T','Y','U','I','O','P','A','S','D','F','G','H','J','K','L','Z','X','C','V','B','N','M'),true)){
            $this->addError($attribute,"必须是A-Z的大写字母");
        }
    }
}
