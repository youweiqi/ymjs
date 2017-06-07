<?php

namespace common\models;

use Yii;
use common\components\Common;


/**
 * This is the model class for table "tg_channel".
 *
 * @property int $id
 * @property string $name 名称
 * @property string $identifier 唯一标识
 * @property string $create_time
 */
class TgChannel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tg_channel';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_goods');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'name', 'identifier'], 'required'],
            [['create_time'], 'safe'],
            [['name', 'identifier'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'identifier' => 'Identifier',
            'create_time' => 'Create Time',
        ];
    }

    public function generateIdentifier()
    {
        do{
            $key = Common::randomKey(8);
        } while (self::findOne(['identifier'=>$key]));
        $this->identifier = $key;
    }
}
