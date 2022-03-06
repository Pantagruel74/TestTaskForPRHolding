<?php

namespace backend\source\apples;

use backend\base\traits\ValidateStrictlyTrait;
use yii\base\ErrorException;
use yii\base\Model;

/**
 * Объект значение цвета яблок
 */
class AppleColorVO extends Model
{
    use ValidateStrictlyTrait;

    /**
     * =================================================================================================================
     * Свойства
     */

    //RGB в десятеричной системе
    const _rDec = 'rDec';
    const _bDec = 'bDec';
    const _gDec = 'gDec';

    public $rDec;
    public $gDec;
    public $bDec;

    /**
     * =================================================================================================================
     * Валидация
     */

    public function rules()
    {
        return [
            [static::_rDec, 'required'],
            [static::_rDec, 'integer', 'min' => 0, 'max' => 255],
            [static::_bDec, 'required'],
            [static::_bDec, 'integer', 'min' => 0, 'max' => 255],
            [static::_gDec, 'required'],
            [static::_gDec, 'integer', 'min' => 0, 'max' => 255],
        ];
    }

    /**
     * =================================================================================================================
     * Логика
     */

    /**
     * Получить значение в шестнадцатеричной системе
     *
     * @return string
     */
    public function getHex()
    {
        $rHex = dechex($this->rDec);
        $gHex = dechex($this->gDec);
        $bHex = dechex($this->bDec);

        $rHex = str_pad($rHex, 2, '0', STR_PAD_LEFT);
        $gHex = str_pad($gHex, 2, '0', STR_PAD_LEFT);
        $bHex = str_pad($bHex, 2, '0', STR_PAD_LEFT);

        return $rHex . $gHex . $bHex;
    }

    /**
     * Установить значение в шестнадцатеричной системе
     *
     * @param $hexInput
     * @return void
     * @throws \ErrorException
     */
    public function setHex($hexInput)
    {
        if(strlen($hexInput) != 6) {
            throw new \ErrorException('Шестнадцатеричный цвет должен состоять из 6 символов');
        }
        if(!ctype_xdigit($hexInput)) {
            throw new \ErrorException('Шестнадцатеричный цвет должен состоять только из символов шестнадцатеричных числел');
        }

        $rHex = substr($hexInput, 0, 2);
        $gHex = substr($hexInput, 2, 2);
        $bHex = substr($hexInput, 4, 2);

        $this->rDec = hexdec($rHex);
        $this->bDec = hexdec($bHex);
        $this->gDec = hexdec($gHex);
    }

    /**
     * Создать объект с помощью значения цвета в шестнадцатеричной системе
     *
     * @param $hexColor
     * @return static
     * @throws \ErrorException
     */
    public static function createByHex($hexColor)
    {
        $newOne = new static();
        $newOne->setHex($hexColor);
        return $newOne;
    }

    /**
     * Создать объект с помощью значения цвета в шестнадцатеричной системе и строго провалидировать
     *
     * @param $hexColor
     * @return static
     * @throws \ErrorException
     */
    public static function createByHexAndValidateStrictly($hexColor)
    {
        $newOne = static::createByHex($hexColor);
        $newOne->validateStrictly();
        return $newOne;
    }
}