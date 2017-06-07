<?php
namespace backend\libraries;


use common\models\CRole;

class MemberLib
{
    public static function getMemberRole()
    {
        $roles = CRole::find()->asArray()->all();
        return $roles;
    }

}