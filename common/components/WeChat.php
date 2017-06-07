<?php
namespace common\components;


class WeChat
{

    const weChatTxtDir = WECHAT_TXT_DIR;
    const weChatPemDir = WECHAT_PEM_DIR;

    public static function saveWeChatTxt ($wechat_txt)
    {
        if (!is_dir(self::weChatTxtDir)){
            mkdir(self::weChatTxtDir);
        }
        //文件名
        $txt_file_name = $wechat_txt->baseName . '.' . $wechat_txt->extension;
        $txt_dir = self::weChatTxtDir . $txt_file_name;
        return $wechat_txt->saveAs($txt_dir);
    }
    public static function saveWeChatPem ($wechat_ca,$store_id)
    {
        if (!is_dir(self::weChatPemDir)){
            mkdir(self::weChatPemDir);
        }
        //文件名
        $ca_file_name = $wechat_ca->baseName.'_'. $store_id . '.'. $wechat_ca->extension;
        $ca_dir = self::weChatPemDir . $ca_file_name;
        if($wechat_ca->saveAs($ca_dir)){
            return $ca_dir;
        }
        return false;
    }



}