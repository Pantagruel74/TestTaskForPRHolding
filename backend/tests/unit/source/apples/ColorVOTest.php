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
}