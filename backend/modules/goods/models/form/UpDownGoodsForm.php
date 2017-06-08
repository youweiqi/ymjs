<?php

namespace backend\modules\goods\models\form;

use common\helpers\ArrayHelper;
use common\models\Goods;
use Yii;
use yii\base\Model;

/**
 * Login form
 */
class UpDownGoodsForm extends Model
{
    public $online_time;
    public $offline_time;
    public $ids;

    public function attributeLabels()
    {
        return [
            'online_time' => '上架时间',
            'offline_time' => '下架时间',
            'ids'=>'ID'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                [['online_time','offline_time'],'required'],
                [['ids','online_time'],'requiredByOne']
        ];
    }

   public function requiredByOne($attribute, $params)
    {

      $a= unserialize($this->ids);

        $goods = Goods::find()->select('id,brand_id,category_id,category_parent_id')->where(['in','id',$a])->asArray()->all();

        $good_ids = ArrayHelper::index($goods,'id');
        $ids= [];
        foreach ($good_ids as $id)
        {
            if($id['brand_id']=='0'||$id['category_id']=='0'||$id['category_parent_id'] == '0'){
               $ids[] = $id['id'];
            }
        }
       $c = implode(',',$ids);

        $this->addError($attribute,'商品Id为'.$c.'的品牌或者分类未设置');

    }


}

