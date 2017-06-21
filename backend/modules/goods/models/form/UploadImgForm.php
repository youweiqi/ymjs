<?php
namespace backend\modules\goods\models\form;
use Yii;
use yii\base\Model;
use common\components\QiNiu;

class UploadImgForm extends Model
{
    public $img;
    public function rules()
    {
        return [
            [['img'],'required','message' =>'{attribute} 是必填的' ],
            [['img'],'image'],
            ['img', 'file', 'extensions' => ['png', 'jpg', 'gif']]
        ];
    }
    public function save()
    {
        $ret = QiNiu::qiNiuUploadByModel($this,'img',"uploadImgForm");
        if(isset($ret['key']))
        {
            return$ret['key'];
        }
        $this->addError('img','服务器内部错误，请联系管理员');
        return false;
    }

}