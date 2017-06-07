<?php
namespace backend\libraries;

use common\models\ExpressCompany;

class ExpressCompanyLib{
    public static function getExpressCompanies ()
    {
        $express_companies = ExpressCompany::find()->where(['status'=>1])->asArray()->all();
        return $express_companies;
    }
}