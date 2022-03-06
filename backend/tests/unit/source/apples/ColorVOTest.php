<?php

namespace unit\source\apples;

use backend\source\apples\AppleColorVO;

class ColorVOTest extends \Codeception\Test\Unit
{
    public function testInitAndValidation()
    {
        $goodConfig1 = [
            AppleColorVO::_rDec => 11,
            AppleColorVO::_bDec => 255,
            AppleColorVO::_gDec => 15,
        ];

        $appleByGoodConfig1 = AppleColorVO::createAndValidateStrictly($goodConfig1);

        $this->assertEquals($appleByGoodConfig1->rDec, 11);
        $this->assertEquals($appleByGoodConfig1->bDec, 255);
        $this->assertEquals($appleByGoodConfig1->gDec, 15);
    }
}