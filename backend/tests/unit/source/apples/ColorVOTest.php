<?php

namespace unit\source\apples;

use backend\source\apples\AppleColorVO;
use yii\base\ErrorException;
use yii\base\InvalidArgumentException;

class ColorVOTest extends \Codeception\Test\Unit
{
    public function testInitAndValidation()
    {
        $appleByGoodConfig1 = AppleColorVO::createAndValidateStrictly([
            AppleColorVO::_rDec => 11,
            AppleColorVO::_bDec => 255,
            AppleColorVO::_gDec => 15,
        ]);

        $this->assertEquals($appleByGoodConfig1->rDec, 11);
        $this->assertEquals($appleByGoodConfig1->bDec, 255);
        $this->assertEquals($appleByGoodConfig1->gDec, 15);

        $this->expectException(\InvalidArgumentException::class);
        $appleByBadConfig1 = AppleColorVO::createAndValidateStrictly([
            AppleColorVO::_rDec => 11,
            AppleColorVO::_gDec => 15,
        ]);

        $this->expectException(\InvalidArgumentException::class);
        $appleByBadConfig2 = AppleColorVO::createAndValidateStrictly([
            AppleColorVO::_rDec => -11,
            AppleColorVO::_gDec => 155,
            AppleColorVO::_bDec => 0,
        ]);

        $this->expectException(\InvalidArgumentException::class);
        $appleByBadConfig3 = AppleColorVO::createAndValidateStrictly([
            AppleColorVO::_rDec => 11,
            AppleColorVO::_gDec => 155,
            AppleColorVO::_bDec => 258,
        ]);
    }

    public function testHexGet()
    {
        $appleByGoodConfig = AppleColorVO::createAndValidateStrictly([
            AppleColorVO::_rDec => 11,
            AppleColorVO::_gDec => 155,
            AppleColorVO::_bDec => 255,
        ]);

        $this->assertEquals($appleByGoodConfig->getHex(), '0b9bff');

        $appleByGoodConfig = AppleColorVO::createAndValidateStrictly([
            AppleColorVO::_rDec => 139,
            AppleColorVO::_gDec => 15,
            AppleColorVO::_bDec => 0,
        ]);

        $this->assertEquals($appleByGoodConfig->getHex(), '8b0f00');
    }

    public function testHexSet()
    {
        $appleByGoodConfig = new AppleColorVO();
        $appleByGoodConfig->setHex('8b0f00');
        $appleByGoodConfig->validateStrictly();
        $this->assertEquals($appleByGoodConfig->rDec, 139);
        $this->assertEquals($appleByGoodConfig->gDec, 15);
        $this->assertEquals($appleByGoodConfig->bDec, 0);

        $appleByGoodConfig = AppleColorVO::createByHexAndValidateStrictly('0b9BFF');
        $this->assertEquals($appleByGoodConfig->rDec, 11);
        $this->assertEquals($appleByGoodConfig->gDec, 155);
        $this->assertEquals($appleByGoodConfig->bDec, 255);

        $this->expectException(\ErrorException::class);
        $appleByGoodConfig = AppleColorVO::createByHexAndValidateStrictly('0b9b56ff');

        $this->expectException(\ErrorException::class);
        $appleByGoodConfig = AppleColorVO::createByHexAndValidateStrictly('0b9bhf');
    }
}