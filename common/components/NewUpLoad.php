<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 22/12/17
 * Time: PM12:01
 */

namespace common\components;


use Yii;
use yii\base\Model;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class NewUpLoad extends Model
{
    public $file;
    private $_appendRules;
    public function init ()
    {
        parent::init();
        $extensions = Yii::$app->params['webuploader']['baseConfig']['accept']['extensions'];
        $this->_appendRules = [
            [['file'], 'file', 'extensions' => $extensions],
        ];
    }
    public function rules()
    {
        $baseRules = [];
        return array_merge($baseRules, $this->_appendRules);
    }
    /**
     *
     */
    public function upImage ()
    {
        $model = new static;
        $model->file = UploadedFile::getInstanceByName('file');//他是要实例化这个文件上传类
        if (!$model->file) {
            return false;
        }
        $relativePath = $successPath = '';
        if ($model->validate()) {
            $relativePath = Yii::$app->params['imageUploadRelativePath'];
            $successPath = Yii::$app->params['imageUploadSuccessPath'];
            $fileName = $model->file->baseName . '.' . $model->file->extension;
            if (!is_dir($relativePath)) {
                FileHelper::createDirectory($relativePath);
            }
            $model->file->saveAs($relativePath . $fileName);
            return [
                'code' => 0,
                'url' => Yii::$app->params['domain'] . $successPath . $fileName,
                'attachment' => $successPath . $fileName
            ];
        } else {
            $errors = $model->errors;
            return [
                'code' => 1,
                'msg' => current($errors)[0]
            ];
        }
    }

    /*
     * 先拿到页面提交的图片的信息
     * 实现七牛批量异步上传图片把处理后的地址以json格式返回
     * 待优化方法:实现真正的异步;相同的图片不上传否则关联店铺的图片就有问题
     */

    public function upImageByQiNiu()
    {
        return  QiNiu::qiNiuUploadByWidgets($_FILES['file']['tmp_name'],'xxx');
      //return  QiNiu::qiNiuUpload($_FILES['file'],'shopex');
    }




}