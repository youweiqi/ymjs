<?php
namespace backend\libraries;


use common\models\CRole;
use common\models\CUser;

class MemberLib
{
    public static function getMemberRole()
    {
        $roles = CRole::find()->asArray()->all();
        return $roles;
    }
    public static function getMember($id)
    {
        $c_user_info=CUser::findOne(['id'=>$id]);
        if(!empty($c_user_info)){
           return $c_user_info->user_name;
        }else{
            return '无';
        }

    }
}