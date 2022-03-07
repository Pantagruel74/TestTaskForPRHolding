<?php

namespace unit\source\apples;

use backend\source\apples\AppleColorVO;
use backend\source\apples\AppleEn;
use backend\source\apples\AppleStatusVO;

class AppleTest extends \Codeception\Test\Unit
{
    public function testInitializationAndValidation()
    {
        $time = time();
        $appleGoodConfigured = AppleEn::createAndValidateStrictly([
            AppleEn::_color => AppleColorVO::createByHexAndValidateStrictly('33f68a'),
            AppleEn::_falledAt => null,
            AppleEn::_createdAt => $time,
            AppleEn::_eatenPercent => 0,
            AppleEn::_status => AppleStatusVO::createAndValidateStrictly([
                AppleStatusVO::_statusCode => AppleStatusVO::STATUS_ON_THE_TREE,
            ])
        ]);
        $this->assertEquals($appleGoodConfigured->getStatusCode(), AppleStatusVO::STATUS_ON_THE_TREE);
        $this->assertEquals($appleGoodConfigured->falledAt, null);
        $this->assertEquals($appleGoodConfigured->createdAt, $time);
        $this->assertEquals($appleGoodConfigured->eatenPercent, 0);
        $this->assertEquals($appleGoodConfigured->color->getHex(), '33f68a');

        $appleGoodConfigured2 = AppleEn::createAndValidateStrictly([
            AppleEn::_color => AppleColorVO::createByHexAndValidateStrictly('33f68a'),
            AppleEn::_falledAt => $time,
            AppleEn::_createdAt => $time,
            AppleEn::_eatenPercent => 20,
            AppleEn::_status => AppleStatusVO::createAndValidateStrictly([
                AppleStatusVO::_statusCode => AppleStatusVO::STATUS_ROTTEN,
            ])
        ]);

        $this->expectException(\InvalidArgumentException::class);
        $appleWithoutColor = AppleEn::createAndValidateStrictly([
            AppleEn::_color => null,
            AppleEn::_falledAt => null,
            AppleEn::_createdAt => $time,
            AppleEn::_eatenPercent => 0,
            AppleEn::_status => AppleStatusVO::createAndValidateStrictly([
                AppleStatusVO::_statusCode => AppleStatusVO::STATUS_ON_THE_TREE,
            ])
        ]);

        $this->expectException(\InvalidArgumentException::class);
        $appleWithInvalidColor = AppleEn::createAndValidateStrictly([
            AppleEn::_color => AppleColorVO::createByHexAndValidateStrictly('33g68a'),
            AppleEn::_falledAt => null,
            AppleEn::_createdAt => $time,
            AppleEn::_eatenPercent => 0,
            AppleEn::_status => AppleStatusVO::createAndValidateStrictly([
                AppleStatusVO::_statusCode => AppleStatusVO::STATUS_ON_THE_TREE,
            ])
        ]);

        $this->expectException(\InvalidArgumentException::class);
        $appleWithInvalidFallenAtProp = AppleEn::createAndValidateStrictly([
            AppleEn::_color => AppleColorVO::createByHexAndValidateStrictly('33c68a'),
            AppleEn::_falledAt => 'aa',
            AppleEn::_createdAt => $time,
            AppleEn::_eatenPercent => 0,
            AppleEn::_status => AppleStatusVO::createAndValidateStrictly([
                AppleStatusVO::_statusCode => AppleStatusVO::STATUS_ON_THE_TREE,
            ])
        ]);

        $this->expectException(\InvalidArgumentException::class);
        $appleWithInvalidFallenAtAndStatusPropsCombination = AppleEn::createAndValidateStrictly([
            AppleEn::_color => AppleColorVO::createByHexAndValidateStrictly('33c68a'),
            AppleEn::_falledAt => null,
            AppleEn::_createdAt => $time,
            AppleEn::_eatenPercent => 0,
            AppleEn::_status => AppleStatusVO::createAndValidateStrictly([
                AppleStatusVO::_statusCode => AppleStatusVO::STATUS_ROTTEN,
            ])
        ]);

        $this->expectException(\InvalidArgumentException::class);
        $appleWithInvalidCreatedAtProp = AppleEn::createAndValidateStrictly([
            AppleEn::_color => AppleColorVO::createByHexAndValidateStrictly('33c68a'),
            AppleEn::_falledAt => null,
            AppleEn::_createdAt => null,
            AppleEn::_eatenPercent => 0,
            AppleEn::_status => AppleStatusVO::createAndValidateStrictly([
                AppleStatusVO::_statusCode => AppleStatusVO::STATUS_ON_THE_TREE,
            ])
        ]);

        $this->expectException(\InvalidArgumentException::class);
        $appleWithInvalidCreatedAtAndFalledAtPropsCombination = AppleEn::createAndValidateStrictly([
            AppleEn::_color => AppleColorVO::createByHexAndValidateStrictly('33c68a'),
            AppleEn::_falledAt => $time,
            AppleEn::_createdAt => $time + 10,
            AppleEn::_eatenPercent => 0,
            AppleEn::_status => AppleStatusVO::createAndValidateStrictly([
                AppleStatusVO::_statusCode => AppleStatusVO::STATUS_ON_THE_GROUND,
            ])
        ]);

        $this->expectException(\InvalidArgumentException::class);
        $appleWithInvalidCreatedAtProp = AppleEn::createAndValidateStrictly([
            AppleEn::_color => AppleColorVO::createByHexAndValidateStrictly('33c68a'),
            AppleEn::_falledAt => null,
            AppleEn::_createdAt => 'aa',
            AppleEn::_eatenPercent => 0,
            AppleEn::_status => AppleStatusVO::createAndValidateStrictly([
                AppleStatusVO::_statusCode => AppleStatusVO::STATUS_ON_THE_TREE,
            ])
        ]);

        $this->expectException(\InvalidArgumentException::class);
        $appleWithInvalidEatenPercentProp = AppleEn::createAndValidateStrictly([
            AppleEn::_color => AppleColorVO::createByHexAndValidateStrictly('33c68a'),
            AppleEn::_falledAt => null,
            AppleEn::_createdAt => $time,
            AppleEn::_eatenPercent => -10,
            AppleEn::_status => AppleStatusVO::createAndValidateStrictly([
                AppleStatusVO::_statusCode => AppleStatusVO::STATUS_ON_THE_TREE,
            ])
        ]);

        $this->expectException(\InvalidArgumentException::class);
        $appleWithInvalidEatenPercentProp = AppleEn::createAndValidateStrictly([
            AppleEn::_color => AppleColorVO::createByHexAndValidateStrictly('33c68a'),
            AppleEn::_falledAt => null,
            AppleEn::_createdAt => $time,
            AppleEn::_eatenPercent => 102,
            AppleEn::_status => AppleStatusVO::createAndValidateStrictly([
                AppleStatusVO::_statusCode => AppleStatusVO::STATUS_ON_THE_TREE,
            ])
        ]);

        $this->expectException(\InvalidArgumentException::class);
        $appleWithInvalidEatenPercentProp = AppleEn::createAndValidateStrictly([
            AppleEn::_color => AppleColorVO::createByHexAndValidateStrictly('33c68a'),
            AppleEn::_falledAt => null,
            AppleEn::_createdAt => $time,
            AppleEn::_eatenPercent => 'aaf',
            AppleEn::_status => AppleStatusVO::createAndValidateStrictly([
                AppleStatusVO::_statusCode => AppleStatusVO::STATUS_ON_THE_TREE,
            ])
        ]);

        $this->expectException(\InvalidArgumentException::class);
        $appleWithInvalidEatenPercentAndStatusPropsCombination = AppleEn::createAndValidateStrictly([
            AppleEn::_color => AppleColorVO::createByHexAndValidateStrictly('33c68a'),
            AppleEn::_falledAt => null,
            AppleEn::_createdAt => $time,
            AppleEn::_eatenPercent => 15,
            AppleEn::_status => AppleStatusVO::createAndValidateStrictly([
                AppleStatusVO::_statusCode => AppleStatusVO::STATUS_ON_THE_TREE,
            ])
        ]);

        $this->expectException(\InvalidArgumentException::class);
        $appleWithInvalidStatusProp = AppleEn::createAndValidateStrictly([
            AppleEn::_color => AppleColorVO::createByHexAndValidateStrictly('33c68a'),
            AppleEn::_falledAt => null,
            AppleEn::_createdAt => $time,
            AppleEn::_eatenPercent => 0,
            AppleEn::_status => AppleStatusVO::createAndValidateStrictly([
                AppleStatusVO::_statusCode => 7,
            ])
        ]);

        $this->expectException(\InvalidArgumentException::class);
        $appleWithInvalidStatusProp = AppleEn::createAndValidateStrictly([
            AppleEn::_color => AppleColorVO::createByHexAndValidateStrictly('33c68a'),
            AppleEn::_falledAt => null,
            AppleEn::_createdAt => $time,
            AppleEn::_eatenPercent => 0,
            AppleEn::_status => 'aa'
        ]);
    }

    public function testFalling()
    {
        $apple = AppleEn::createAndValidateStrictly([
            AppleEn::_color => AppleColorVO::createByHexAndValidateStrictly('33f68a'),
            AppleEn::_falledAt => null,
            AppleEn::_createdAt => time(),
            AppleEn::_eatenPercent => 0,
            AppleEn::_status => AppleStatusVO::createAndValidateStrictly([
                AppleStatusVO::_statusCode => AppleStatusVO::STATUS_ON_THE_TREE,
            ])
        ]);
        $this->assertEquals($apple->getStatusCode(), AppleStatusVO::STATUS_ON_THE_TREE);
        $apple->fall();
        $this->assertEquals($apple->getStatusCode(), AppleStatusVO::STATUS_ON_THE_GROUND);

        $apple->status->statusCode = AppleStatusVO::STATUS_ROTTEN;
        $this->expectException(\DomainException::class);
        $apple->fall();

        $time = time();
        $apple = AppleEn::createAndValidateStrictly([
            AppleEn::_color => AppleColorVO::createByHexAndValidateStrictly('33f68a'),
            AppleEn::_falledAt => null,
            AppleEn::_createdAt => $time,
            AppleEn::_eatenPercent => 0,
            AppleEn::_status => AppleStatusVO::createAndValidateStrictly([
                AppleStatusVO::_statusCode => AppleStatusVO::STATUS_ON_THE_TREE,
            ])
        ]);
        $apple->fall($time + 10);
        $this->assertEquals($apple->falledAt, $time + 10);

        $apple = AppleEn::createAndValidateStrictly([
            AppleEn::_color => AppleColorVO::createByHexAndValidateStrictly('33f68a'),
            AppleEn::_falledAt => null,
            AppleEn::_createdAt => $time,
            AppleEn::_eatenPercent => 0,
            AppleEn::_status => AppleStatusVO::createAndValidateStrictly([
                AppleStatusVO::_statusCode => AppleStatusVO::STATUS_ON_THE_TREE,
            ])
        ]);
        $this->expectException(\DomainException::class);
        $apple->fall($time - 10);
    }
}