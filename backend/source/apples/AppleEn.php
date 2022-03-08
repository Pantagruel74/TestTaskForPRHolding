<?php

namespace backend\source\apples;

use backend\base\traits\ValidateStrictlyTrait;
use backend\base\validators\ClassValidator;
use backend\base\validators\ValidModelValidator;
use yii\base\ErrorException;
use yii\base\Model;

/**
 * Сущность яблока
 *
 * @property AppleColorVO $color
 * @property int $createdAt
 * @property int $falledAt
 * @property AppleStatusVO $status
 * @property double $eatenPercent
 */
class AppleEn extends Model
{
    use ValidateStrictlyTrait;

    /**
     * =================================================================================================================
     * Свойства
     */

    const _color = 'color';
    const _createdAt = 'createdAt';
    const _falledAt = 'falledAt';
    const _status = 'status';
    const _eatenPercent = 'eatenPercent';

    public $color;
    public $createdAt;
    public $falledAt;
    public $status;
    public $eatenPercent;

    /**
     * =================================================================================================================
     * Валидация
     */

    public static function ruleForColor($attribute, $object): array
    {
        return [
            [$attribute, 'required'],
            [$attribute, ClassValidator::class, ClassValidator::_expected => AppleColorVO::class],
            [$attribute, ValidModelValidator::class],
        ];
    }

    public static function ruleForCreatedAt($attribute, $object): array
    {
        return [
            [$attribute, 'required'],
            [$attribute, 'integer']
        ];
    }



    public static function ruleForFalledAt($attribute, $object): array
    {
        return [
            [$attribute, 'integer'],
            [$attribute, FalledAtValidator::class,
                FalledAtValidator::_statusAttributeName => static::_status,
                FalledAtValidator::_createdAtAttributeName => static::_createdAt,
            ],
        ];
    }

    public static function ruleForStatus($attribute, $object): array
    {
        return [
            [$attribute, 'required'],
            [$attribute, ClassValidator::class, ClassValidator::_expected => AppleStatusVO::class],
            [$attribute, ValidModelValidator::class]
        ];
    }

    public static function ruleForEatenPercent($attribute, $object): array
    {
        return [
            [$attribute, 'required'],
            [$attribute, 'double', 'min' => 0, 'max' => 100],
            [$attribute, EatenPercentValidator::class, EatenPercentValidator::_statusAttributeName => static::_status],
        ];
    }

    public function rules():array
    {
        return array_merge(
            static::ruleForColor(static::_color, $this),
            static::ruleForStatus(static::_status, $this),
            static::ruleForCreatedAt(static::_createdAt, $this),
            static::ruleForEatenPercent(static::_eatenPercent, $this),
            static::ruleForFalledAt(static::_falledAt, $this)
        );
    }

    /**
     * =================================================================================================================
     * Логика
     */

    /**
     * Падение яблока с дерева
     *
     * @return void
     * @throws \DomainException
     */
    public function fall($time = null)
    {
        if(!$time) {
            $time = time();
        }
        if($time < $this->createdAt) {
            throw new \DomainException('Яблоко не может упасть раньше, чем было создано');
        }
        $this->falledAt = $time;
        if($this->getStatusCode() != AppleStatusVO::STATUS_ON_THE_TREE) {
            throw new \DomainException('Яблоко может упасть только если ранее висело на дереве');
        }
        $this->status->statusCode = AppleStatusVO::STATUS_ON_THE_GROUND;
        $this->validateStrictly();
    }

    /**
     * Откусывание яблока
     *
     * @param $percent
     * @return void
     * @throws \DomainException
     */
    public function bit($percent)
    {
        if($this->getStatusCode() == AppleStatusVO::STATUS_ON_THE_TREE)
        {
            throw new \DomainException('Пока яблоко висит на дереве, съесть не получится');
        }
        elseif($this->getStatusCode() == AppleStatusVO::STATUS_ROTTEN)
        {
            throw new \DomainException('Когда испорчено, съесть не получится');
        }
        elseif($this->getStatusCode() == AppleStatusVO::STATUS_TO_DELETE)
        {
            throw new \DomainException('Не существующее яблоко съесть не получится');
        }

        $this->eatenPercent += $percent;
        if($this->eatenPercent >= (100 - 0.0001)) {
            $this->delete();
        } else {
            $this->validateStrictly();
        }
    }

    /**
     * Яблоко прогнивает
     *
     * @return void
     * @throws \DomainException
     */
    public function rot()
    {
        if($this->getStatusCode() == AppleStatusVO::STATUS_ON_THE_TREE)
        {
            throw new \DomainException('Пока яблоко висит на дереве, испортиться не может');
        }
        elseif($this->getStatusCode() == AppleStatusVO::STATUS_ROTTEN)
        {
            throw new \DomainException('Яблоко уже прогнило');
        }
        elseif($this->getStatusCode() == AppleStatusVO::STATUS_TO_DELETE)
        {
            throw new \DomainException('Не существующее яблоко не может прогнить');
        }

        $this->status->statusCode = AppleStatusVO::STATUS_ROTTEN;
        $this->validateStrictly();

    }

    /**
     * Удалить яблоко
     *
     * @return void
     */
    public function delete()
    {
        $this->status->statusCode = AppleStatusVO::STATUS_TO_DELETE;
    }

    /**
     * Получить код статуса
     *
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->status->statusCode;
    }

}