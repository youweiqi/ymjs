<?php

namespace backend\modules\warehouse\models\form;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class ImportInventoryForm extends Model
{
    public $import_file;
    public $import_error;

    public function attributeLabels()
    {
        return [
            'import_file' => '导入文件',
            'import_error'=>'错误信息',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['import_file'], 'file'],
            ['import_error','safe'],
        ];
    }
}
