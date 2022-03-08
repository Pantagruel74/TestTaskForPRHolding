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
    const _id = 'id';

    public $bitPercent;
    public $maxBit;
    public $id;

    /**
     * =================================================================================================================
     * Валидация
     */

    const SCENARIO_CREATE = 'create';

    public function rules()
    {
        return [
            [static::_bitPercent, 'required', 'except' => static::SCENARIO_CREATE],
            [static::_bitPercent, 'number', 'min' => 0, 'max' => $this->maxBit],
            [static::_id, 'integer', 'min' => 0],
            [static::_id, 'required', 'except' => static::SCENARIO_CREATE],
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
            'scenario' => static::SCENARIO_CREATE,
            static::_bitPercent => 0,
            static::_maxBit => (100 - $appleEn->eatenPercent),
            static::_id => $appleEn->id,
        ]);
    }

}