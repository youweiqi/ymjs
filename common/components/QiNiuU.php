<?php
namespace common\components;

use Yii;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;
use yii\base\Object;
use yii\web\UploadedFile;
use Qiniu\Storage\BucketManager;
use yii\helpers\Url;

class QiNiuU extends Object
{
    const accessKey = QINIU_ACCESSKEY;
    const secretKey = QINIU_SECRETKEY;
    const bucket    = QINIU_BUCKET;
    const policy = array(
        'callbackUrl' => QINIU_CALLBACK,
        'callbackBody' => 'filename=$(fname)&filesize=$(fsize)'
    );
    static private $auth = null;
    static private $token = null;
    static private $up_token = null;
    static private $bucket_mgr = null;
    /**
     * [七牛上传图片]
     * @param [type]  $model         [实例化模型]
     * @param [type]  $attribute     [图片字段]
     * @param [type]  $model_name    [模型名称]
     * @return  mixed
     */
    public function uploadImg($model,$attribute,$model_name)
    {
        $img_path = '';
        //返回一个实例化对象
        $img_instance = UploadedFile::getInstance($model,$attribute);
        if($img_instance){
            //图片本地临时目录
            $file_path = $img_instance->tempName;
            $new_path = 'images/'.$model_name. '/'.date("YmdHis").mt_rand(1000,9999).'.'.$img_instance->getExtension();
            $image_ret = self::uploadFile($file_path,$new_path);
            if(isset($image_ret['key'])){
                $img_path = QINIU_URL.$image_ret['key'];
            }
        }
        return $img_path;
    }

    private function getToken($is_callback=false)
    {
        if(empty(self::$auth)) self::$auth = new Auth(self::accessKey, self::secretKey);
        if($is_callback){
            if(empty(self::$up_token)) self::$up_token = self::$auth->uploadToken(self::bucket, null, 3600, self::policy);
            return self::$up_token;
        }else{
            if(empty(self::$token)) self::$token = self::$auth->uploadToken(self::bucket);
            return self::$token;
        }
    }

    public function uploadFile($file_path,$key)
    {
        $token = $this->getToken();
        // 初始化 UploadManager 对象并进行文件的上传
        $uploadMgr = new UploadManager();
        // 调用 UploadManager 的 putFile 方法进行文件的上传
        list($ret, $err) = $uploadMgr->putFile($token, $key, $file_path);
        if ($err !== null) {
            return $err;
        } else {
            return $ret;
        }
    }

    /**
     * 获取初始化BucketManager.
     */
    private function getBucketManager()
    {
        //初始化Auth状态
        if(empty(self::$auth)) self::$auth = new Auth(self::accessKey, self::secretKey);
        //初始化BucketManager
        self::$bucket_mgr = new BucketManager(self::$auth);
    }

    public function uploadFileCallback($file_path,$key)
    {
        $token = $this->getToken(true);
        // 初始化 UploadManager 对象并进行文件的上传
        $uploadMgr = new UploadManager();
        // 调用 UploadManager 的 putFile 方法进行文件的上传
        list($ret, $err) = $uploadMgr->putFile($token, $key, $file_path);
        if ($err !== null) {
            return $err;
        } else {
            return $ret;
        }
    }

    /**
     * 七牛通过model文件上传这里上传成功后把图片的地址进行返回
     * @param  \yii\base\Model $model
     * @param  string $attribute  图片字段
     * @param  string $model_name 类名称
     * @return mixed
     */
    public function qiNiuUploadByModel ($model,$attribute,$model_name)
    {
        $img_instance = UploadedFile::getInstance($model,$attribute);
        if($img_instance){
            //图片本地临时目录
            $file_path = $img_instance->tempName;
            //图片在七牛的路径
            $key = 'images/'.$model_name. '/'.date("YmdHis").mt_rand(1000,9999).'.'.$img_instance->extension;
            return $this->uploadFile($file_path,$key);
        }else{
            return [];
        }
    }

    /**
     * 七牛文件上传 直接上传,这里上传成功后把图片的地址进行返回
     * @param  array $upload_image
     * @param  string $model_name
     * @return mixed
     */
    public function qiNiuUpload ($upload_image,$model_name)
    {
        if($upload_image){
            //图片本地临时目录
            $file_path = $upload_image['tmp_name'];
            list($type, $extension) = explode('/',$upload_image['type']);
            //图片在七牛的路径
            $key = 'images/'.$model_name. '/'.date("YmdHis").mt_rand(1000,9999).'.'.$extension;
            return $this->uploadFile($file_path,$key);
        }else{
            return [];
        }
    }

    /**
     * 删除七牛图片
     * @param  string $key
     */
    public function deleteFile($key)
    {
        if(empty(self::$bucket_mgr)) self::getBucketManager();
        $response = self::$bucket_mgr->delete(self::bucket, $key);
    }
}