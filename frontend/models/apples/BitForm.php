<?php

namespace frontend\models\apples;

use backend\base\traits\ValidateStrictlyTrait;
use backend\source\apples\AppleEn;
use yii\base\Model;

class BitForm extends Model
{
    use ValidateStrictlyTrait;

    /**
     * =================================================================================================================
     * Свойства
     */

    const _bitPercent = 'bitPercent';
    const _maxBit = 'maxBit';

    public $bitPercent;
    public $maxBit;

    /**
     * =================================================================================================================
     * Валидация
     */

    public function rules()
    {
        return [
            [static::_bitPercent, 'number', 'min' => 0, 'max' => $this->maxBit],
        ];
    }

    /**
     * =================================================================================================================
     * Логика
     */

    public function attributeLabels():array
    {
        return [
            static::_bitPercent => 'Откусить, %',
        ];
    }

    /**
     * Инициализировать из сущности яблока
     *
     * @param AppleEn $appleEn
     * @return static
     */
    public static function createByAppleEn(AppleEn $appleEn):self
    {
        return static::createAndValidateStrictly([
            static::_bitPercent => 0,
            static::_maxBit => (100 - $appleEn->eatenPercent)
        ]);
    }

}