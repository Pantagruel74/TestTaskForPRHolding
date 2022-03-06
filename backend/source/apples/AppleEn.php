<?php

namespace backend\source\apples;

use backend\base\traits\ValidateStrictlyTrait;
use yii\base\Model;

class AppleEn extends Model
{
    use ValidateStrictlyTrait;

    /**
     * =================================================================================================================
     * Свойства
     */

    const _color = 'color';
    const _createdAt = 'createdAt';
    const _falledAt = 'fallenAt';
    const _status = 'status';
    const _eatenPercent = 'eatenPercent';

    public $color;
    public $createdAt;
    public $fallenAt;
    public $status;
    public $eatenPercent;

    /**
     * =================================================================================================================
     * Валидация
     */

    public static function ruleForColor($attribute, $object)
    {
        return [
            [$attribute, 'required'],
            [$attribute, 'string', 'length' => 6],
        ];
    }

    /**
     * =================================================================================================================
     * Логика
     */

    public function fall()
    {
        //TODO: finish it
    }

    public function bit($percent)
    {
        //Todo: finish it
    }

    public function delete()
    {
        //TODO: finish it
    }
}