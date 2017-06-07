<?php
namespace backend\modules\tgtools\models\form;
use yii\base\Model;
use common\models\TgChannel;

/**
 * Created by PhpStorm.
 * User: suns
 * Date: 2017/5/13
 * Time: 上午11:20
 */
class ChannelCreateForm extends Model
{
    public $name;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
        ];
    }
    public function save()
    {
        $channel = new TgChannel();
        $channel->create_time = date('Y-m-d H:i:s');
        $channel->generateIdentifier();
        $channel->name = $this->name;
        $result = $channel->save();
        return $result;
    }

}