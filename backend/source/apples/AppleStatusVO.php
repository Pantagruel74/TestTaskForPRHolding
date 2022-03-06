<?php

namespace backend\source\apples;

use backend\base\traits\ValidateStrictlyTrait;
use yii\base\Model;

class AppleStatusVO extends Model
{
    use ValidateStrictlyTrait;

    /**
     * =================================================================================================================
     * Свойства
     */

    const _statusCode = 'statusCode';

    public $statusCode;

    /**
     * =================================================================================================================
     * Валидация
     */

    public function rules():array
    {
        return [
            [static::_statusCode, 'required'],
            [static::_statusCode, 'integer', 'min' => min(static::getList()), 'max' => max(static::getList())]
        ];
    }

    /**
     * =================================================================================================================
     * Справочник
     */

    const STATUS_ON_THE_TREE = 1;
    const STATUS_ON_THE_GROUND = 2;
    const STATUS_ROTTEN = 3;
    const STATUS_TO_DELETE = 4;

    public static function getLabels():array
    {
        return [
            static::STATUS_ON_THE_TREE => 'Висит на дереве',
            static::STATUS_ON_THE_GROUND => 'Лежит на земле',
            static::STATUS_ROTTEN => 'Сгнило',
            static::STATUS_TO_DELETE => 'Удаляется'
        ];
    }

    public static function getList():array
    {
        return array_keys(static::getLabels());
    }
}