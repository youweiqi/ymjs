<?php

namespace common\components\excel\import\advanced;

use common\components\excel\behaviors\CellBehavior;
use common\components\excel\import\basic\Attribute as BasicAttribute;
use common\components\excel\import\DI;
use common\components\excel\import\exceptions\CellException;
use Yii;

/**
 * @property Model $relatedModel
 */
class Attribute extends BasicAttribute
{
    const EVENT_INIT = 'init';

    /**
     * @var Model
     */
    protected $_relatedModel;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            CellBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        if (!DI::getCellParser()->isLoadedPk($this->cell)) {
            parent::init();
        }

        $this->trigger(self::EVENT_INIT);
    }

    public function linkRelatedModel()
    {
        $cell = $this->getInitialCell();

        if (!DI::getCellParser()->isLoadedPk($cell)) {
            return;
        }

        $loadedPk = DI::getCellParser()->getLoadedPk($cell);
        foreach (array_reverse(DI::getImporter()->models) as $model) {
            $isRelatedByPk = $loadedPk && $model->savedPk == $loadedPk;

            $attributeModelClass = $this->_standardAttribute->standardModel->className;
            $modelClass = $model->standardModel->className;
            $isRelatedByLastPk = $loadedPk === '' && $attributeModelClass != $modelClass;

            if ($isRelatedByPk || $isRelatedByLastPk) {
                $this->_relatedModel = $model;

                break;
            }
        }

        if (!$this->_relatedModel) {
            throw new CellException($cell, 'Related model not found.');
        }
    }

    /**
     * @return Model
     */
    public function getRelatedModel()
    {
        return $this->_relatedModel;
    }

    /**
     * @param Model $value
     */
    public function setRelatedModel($value)
    {
        $this->_relatedModel = $value;
    }
}
