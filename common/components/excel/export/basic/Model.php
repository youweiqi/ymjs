<?php

namespace common\components\excel\export\basic;

use common\components\excel\components\Model as BaseModel;

/**
 * @var StandardModel $standardModel
 */
class Model extends BaseModel
{
    /**
     * @inheritdoc
     */
    protected static $attributeClassName = 'common\components\excel\export\basic\Attribute';

    /**
     * @inheritdoc
     */
    protected function initAttributes()
    {
        foreach ($this->_standardModel->standardAttributes as $standardAttribute) {
            $this->initAttribute(['standardAttribute' => $standardAttribute]);
        }
    }

    /**
     * @param \PHPExcel_Worksheet $sheet
     * @param integer $row
     */
    public function exportAttributeValues($sheet, $row)
    {
        foreach ($this->_attributes as $attribute) {
            $sheet->setCellValue($attribute->standardAttribute->column . $row, $attribute->value);
        }
    }
}
