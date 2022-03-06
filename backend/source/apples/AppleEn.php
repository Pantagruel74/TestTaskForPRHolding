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

    /**
     * =================================================================================================================
     * Валидация
     */

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