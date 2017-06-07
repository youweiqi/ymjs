<?php
namespace backend\libraries;


use common\models\CRole;

class MemberLib
{
    public static function getMemberRole($role_id)
    {
        $role_arr = [];
        $roles = CRole::find()->asArray()->all();
        foreach ($roles as $role)
        {
            if($role['level']!=600){
                $role_arr[$role['id']] = $role['role_name'];
            }else{
                if($role['id']==$role_id){
                    $role_arr[$role['id']] = $role['role_name'];
                }
            }
        }
        return $role_arr;
    }

}