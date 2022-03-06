<?php

namespace unit\source\apples;

use backend\source\apples\AppleEn;

class AppleTest extends \Codeception\Test\Unit
{
    public function testBase()
    {
        $apple = AppleEn::createAndValidateStrictly([]);
    }
}