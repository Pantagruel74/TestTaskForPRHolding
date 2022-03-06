<?php

namespace unit\source\apples;

use backend\source\apples\AppleStatusVO;

class AppleStatusTest extends \Codeception\Test\Unit
{
    public function testInitAndValidate()
    {
        $appleStatusGoodConfigured = AppleStatusVO::createAndValidateStrictly([
            AppleStatusVO::_statusCode => AppleStatusVO::STATUS_ON_THE_GROUND,
        ]);

        $this->expectException(\InvalidArgumentException::class);
        $appleStatusBadConfigured1 = AppleStatusVO::createAndValidateStrictly([
            AppleStatusVO::_statusCode => -1,
        ]);

        $this->expectException(\InvalidArgumentException::class);
        $appleStatusBadConfigured1 = AppleStatusVO::createAndValidateStrictly([
            AppleStatusVO::_statusCode => 10,
        ]);
    }
}