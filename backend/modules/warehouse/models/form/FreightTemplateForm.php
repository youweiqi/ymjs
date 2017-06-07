<?php

namespace backend\modules\warehouse\models\form;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class FreightTemplateForm extends Model
{
    public $ids;
    public $freight_template_id;

    public function attributeLabels()
    {
        return [
            'ids'=>'ID',
            'freight_template_id'=>'运费模板'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ids'],'safe'],
            ['freight_template_id','integer']
        ];
    }
}
