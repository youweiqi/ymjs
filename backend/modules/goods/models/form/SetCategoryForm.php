<?php

namespace backend\modules\goods\models\form;


use Yii;
use yii\base\Model;


/**
 * RedeemCodeForm
 */
class SetCategoryForm extends Model
{
    public $ids;
    public $category_parent_id;
    public $category_id;
    public $brand_id;



    public function attributeLabels()
    {
        return [
             'ids'=>'IDS',
            'brand_id' => '品牌',
            'category_parent_id' => '二级分类',
            'category_id' => '三级分类',

        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_parent_id','category_id','brand_id'], 'required'],
            [['category_parent_id','category_id','brand_id'], 'integer'],
            ['ids','safe']
        ];
    }

}
