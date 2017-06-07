<?php
namespace backend\libraries;

use common\models\UserJournal;
use Yii;

class MemberJournalLib{

    public static function createAction($ids){
        $member_journals=UserJournal::find()->where(['in','id',$ids])->asArray()->all();
        $memberJournal_arr=[];
        if(!empty($member_journals)&&is_array($member_journals)){
            foreach ($member_journals as $a){
                $memberJournal['money']=$a['money'];
                $memberJournal['user_id']=$a['user_id'];
                $memberJournal['status']='6';
                $memberJournal['type']='+';
                $memberJournal['promotion_detail_id']='0';
                $memberJournal['bank_id']=$a['bank_id'];
                $memberJournal['comment']=$a['id'].":拒绝提现".$a['money'];
                $memberJournal_arr[]=$memberJournal;
            }
        }
        return  $memberJournal_arr;
    }
}