<?php

namespace backend\modules\warehouse\models\form;


use Yii;
use yii\base\Model;


/**
 * RedeemCodeForm
 */
class ProvinceForm extends Model
{
    public $p010;
    public $p022;
    public $p021;
    public $p023;
    public $p0311;
    public $p0351;
    public $p024;
    public $p0431;
    public $p0451;
    public $p025;
    public $p0571;
    public $p0551;
    public $p0591;
    public $p0791;
    public $p0531;
    public $p0371;
    public $p027;
    public $p0731;
    public $p020;
    public $p0898;
    public $p028;
    public $p0851;
    public $p0871;
    public $p029;
    public $p0931;
    public $p0971;
    public $p0891;
    public $p0471;
    public $p0771;
    public $p0951;
    public $p0991;



    public function attributeLabels()
    {
        return [
            'p010'=>'北京市',
            'p022'=>'天津市',
            'p021'=>'上海市',
            'p023'=>'重庆市',
            'p0311'=>'河北省',
            'p0351'=>'山西省',
            'p024'=>'辽宁省',
            'p0431'=>'吉林省',
            'p0451'=>'黑龙江省',
            'p025'=>'江苏省',
            'p0571'=>'浙江省',
            'p0551'=>'安徽省',
            'p0591'=>'福建省',
            'p0791'=>'江西省',
            'p0531'=>'山东省',
            'p0371'=>'河南省',
            'p027'=>'湖北省',
            'p0731'=>'湖南省',
            'p020'=>'广东省',
            'p0898'=>'海南省',
            'p028'=>'四川省',
            'p0851'=>'贵州省',
            'p0871'=>'云南省',
            'p029'=>'陕西省',
            'p0931'=>'甘肃省',
            'p0971'=>'青海省',
            'p0891'=>'西藏自治区',
            'p0471'=>'内蒙古自治区',
            'p0771'=>'广西壮族自治区',
            'p0951'=>'宁夏回族自治区',
            'p0991'=>'新疆维吾尔自治区'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['p010','p022','p021','p023','p0311','p0351','p024','p0431','p0451','p025','p0571','p0551','p0591','p0791','p0531','p0371','p027','p0731','p020','p0898','p028','p0851','p0871','p029','p0931','p0971','p0891','p0471','p0771','p0951','p0991'
            ],'double', 'numberPattern' => '/^([1-9]\d*|0)(\.\d{1,2})?$/','message'=>'必须为最多两位小数的正数']
        ];
    }

}
