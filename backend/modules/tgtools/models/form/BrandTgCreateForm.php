<?php
namespace backend\modules\tgtools\models\form;
use yii\base\Model;
use common\models\TgLink;
/**
 * Created by PhpStorm.
 * User: suns
 * Date: 2017/5/13
 * Time: 上午11:20
 */
class BrandTgCreateForm extends Model
{
    public $promotion_total_num;
    public $promotion_person_num;
    public $channel_id;
    public $promotion_detail_id;
    public $serial_id;
    public $memo;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['channel_id','required', 'message' => '请选择渠道'],
            ['promotion_detail_id', 'required', 'message' => '请选择品牌券'],
            ['serial_id', 'required', 'message' => '请选择品牌期'],

            ['memo','safe'],
            [['promotion_total_num','promotion_person_num'], 'required'],
            [['promotion_total_num','promotion_person_num'], 'integer','message'=>'必须是整数'],

        ];
    }

    public function save()
    {
        $link = new TgLink();
        $link->create_time = date('Y-m-d H:i:s');
        $link->channel_id = $this->channel_id;
        $link->generateIdentifier();
        $link->promotion_detail_id = $this->promotion_detail_id;
        $link->type = 2;
        $link->memo = $this->memo;
        $link->promotion_person_num = $this->promotion_person_num;
        $link->promotion_total_num = $this->promotion_total_num;
        $link->serial_id = $this->serial_id;
        $result = $link->save();
        return $link;
    }

}