<?php
namespace common\components;

use Yii;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;
use yii\web\UploadedFile;
use Qiniu\Storage\BucketManager;
use yii\helpers\Url;

class QiNiu{
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

    public static function getToken($is_callback=false){
        if(empty(self::$auth)) self::$auth = new Auth(self::accessKey, self::secretKey);
        if($is_callback){
            if(empty(self::$up_token)) self::$up_token = self::$auth->uploadToken(self::bucket, null, 3600, self::policy);
            return self::$up_token;
        }else{
            if(empty(self::$token)) self::$token = self::$auth->uploadToken(self::bucket);
            return self::$token;
        }
    }

    public static function uploadFile($file_path,$key){
        $token = self::getToken();
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
     * @return mixed
     */
    public static function getBucketManager()
    {
        //初始化Auth状态
        if(empty(self::$auth)) self::$auth = new Auth(self::accessKey, self::secretKey);
        //初始化BucketManager
        self::$bucket_mgr = new BucketManager(self::$auth);
    }

    public static function uploadFileCallback($file_path,$key){
        $token = self::getToken(true);
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
    public static function qiNiuUploadByModel ($model,$attribute,$model_name)
    {
        $img_instance = UploadedFile::getInstance($model,$attribute);
        if($img_instance){
            //图片本地临时目录
            $file_path = $img_instance->tempName;
            //图片在七牛的路径
            $key = 'images/'.$model_name. '/'.date("YmdHis").mt_rand(1000,9999).'.'.$img_instance->extension;
            $img_path = self::uploadFile($file_path,$key);
            if(isset($img_path['key'])){
                $img_path['key'] = QINIU_URL.$img_path['key'];
                return $img_path;
            }
        }
        return [];
    }

    /**
     * 七牛文件上传 直接上传,这里上传成功后把图片的地址进行返回
     * @param  array $upload_image
     * @param  string $model_name
     * @return mixed
     */
    public static function qiNiuUpload ($upload_image,$model_name)
    {
        if($upload_image){
            //图片本地临时目录
            $file_path = $upload_image['tmp_name'];
            list($type, $extension) = explode('/',$upload_image['type']);
            //图片在七牛的路径
            $key = 'images/'.$model_name. '/'.date("YmdHis").mt_rand(1000,9999).'.'.$extension;
            return self::uploadFile($file_path,$key);
        }else{
            return [];
        }
    }
    /**
     * 七牛文件上传 直接上传,这里上传成功后把图片的地址进行返回
     * @param  string $file_path base64的数据字符串
     * @param  string $model_name 相关的类名称
     * @return mixed
     */
    public static function qiNiuDirectUpload ($file_path,$model_name)
    {
        if($file_path){
            //图片本地临时目录
            $extension = self::getImgExtension($file_path);
            //图片在七牛的路径
            $key = 'images/'.$model_name. '/'.date("YmdHis").mt_rand(1000,9999).'.'.$extension;
            $img_path = self::uploadFile($file_path,$key);
            if(isset($img_path['key'])){
                $img_path['key'] = QINIU_URL.$img_path['key'];
                return $img_path;
            }
        }
        return [];
    }
    /**
     * 获取base64编码后的图片的扩展后缀名成.
     * @param  string $image_path   base64处理后的图片信息
     * @return mixed $extension   图片的后缀名称
     */
    public static function getImgExtension($image_path)
    {
        list($extension_info,$data) = explode(',', $image_path);
        switch ($extension_info){
            case 'data:image/jpeg;base64' :
                $extension = 'jpg';
                break;
            case 'data:image/png;base64' :
                $extension = 'png';
                break;
            case 'data:image/bmp;base64' :
                $extension = 'bmp';
                break;
            case 'data:image/gif;base64' :
                $extension = 'gif';
                break;
            default :
                $extension = '';
                break;
        }
        return $extension;

    }
    /**
     * 通过控件上传七牛文件 ,这里上传成功后把图片的地址进行返回
     * @param  string $file_path
     * @param  string $model_name
     * @return mixed
     */
    public static function qiNiuUploadByWidget ($file_path,$model_name)
    {

        $img_instance = UploadedFile::getInstanceByName($file_path);
        if($img_instance){
            //图片本地临时目录
            $file_path = $img_instance->tempName;
            //图片在七牛的路径
            $key = 'images/'.$model_name. '/'.date("YmdHis").mt_rand(1000,9999).'.'.$img_instance->extension;
            return self::uploadFile($file_path,$key);
        }else{
            return [];
        }

    }

    /**
     * 删除七牛图片
     * @param  string $key 图片在七牛上的存储名称
     * @return mixed
     */
    public static function deleteFile($key)
    {
        if(empty(self::$bucket_mgr)) self::getBucketManager();
        $response = self::$bucket_mgr->delete(self::bucket, $key);
    }
}