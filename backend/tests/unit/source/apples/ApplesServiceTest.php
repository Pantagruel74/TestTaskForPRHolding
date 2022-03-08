<?php

namespace unit\source\apples;

use backend\source\apples\AppleEn;
use backend\source\apples\ApplesService;
use backend\source\apples\AppleStatusVO;
use backend\tests\unit\source\apples\st\AppleRepositorySt;

class ApplesServiceTest extends \Codeception\Test\Unit
{
    public function testCreation()
    {
        $goodService = ApplesService::createAndValidateStrictly([
            ApplesService::_unixTime => time(),
            ApplesService::_applesRepository => new AppleRepositorySt([
                AppleRepositorySt::_applesArray => AppleRepositorySt::defaultArrayForTests()
            ])
        ]);

        $this->expectException(\InvalidArgumentException::class);
        $badInitService1 = ApplesService::createAndValidateStrictly([
            ApplesService::_unixTime => 0.12,
            ApplesService::_applesRepository => new  AppleRepositorySt([
                AppleRepositorySt::_applesArray => AppleRepositorySt::defaultArrayForTests()
            ])
        ]);

        $this->expectException(\InvalidArgumentException::class);
        $badInitService2 = ApplesService::createAndValidateStrictly([
            ApplesService::_unixTime => 0.12,
            ApplesService::_applesRepository => (object) [],
        ]);
    }

    public function testGetAll()
    {
        $defaultArrayForTests = AppleRepositorySt::defaultArrayForTests();
        $applesService = ApplesService::createAndValidateStrictly([
            ApplesService::_unixTime => time(),
            ApplesService::_applesRepository => new AppleRepositorySt([
                AppleRepositorySt::_applesArray => AppleRepositorySt::defaultArrayForTests()
            ])
        ]);
        $apples = $applesService->getAll();
        foreach ($apples as $appleKey => $appleVal)
        {
            /* @var AppleEn $appleVal */
            /* @var AppleEn[] $defaultArrayForTests */
            $this->assertEquals($appleVal->id, $defaultArrayForTests[$appleKey]->id);
            $this->assertEquals($appleVal->color->getHex(), $defaultArrayForTests[$appleKey]->color->getHex());
            $this->assertEquals($appleVal->getStatusCode(), $defaultArrayForTests[$appleKey]->getStatusCode());
            $this->assertEquals($appleVal->eatenPercent, $defaultArrayForTests[$appleKey]->eatenPercent);
            $this->assertEquals($appleVal->createdAt, $defaultArrayForTests[$appleKey]->createdAt);
            $this->assertEquals($appleVal->falledAt, $defaultArrayForTests[$appleKey]->falledAt);
        }
    }

    public function testDeleteAll()
    {
        $defaultArrayForTests = AppleRepositorySt::defaultArrayForTests();
        $applesService = ApplesService::createAndValidateStrictly([
            ApplesService::_unixTime => time(),
            ApplesService::_applesRepository => new AppleRepositorySt([
                AppleRepositorySt::_applesArray => AppleRepositorySt::defaultArrayForTests()
            ])
        ]);
        $this->assertEquals(count($applesService->getAll()), count($defaultArrayForTests));

        $applesService->deleteAll();
        $this->assertEquals(count($applesService->getAll()), 0);
    }

    public function testRandomInit()
    {
        $applesService = ApplesService::createAndValidateStrictly([
            ApplesService::_unixTime => time(),
            ApplesService::_applesRepository => new AppleRepositorySt([
                AppleRepositorySt::_applesArray => [],
            ])
        ]);
        $applesService->resetAppleByRandomNum();
        $this->assertEquals(count($applesService->getAll()) > 0, true);

        foreach ($applesService->getAll() as $apple)
        {
            /* @var AppleEn $apple */
            $apple->validateStrictly();
        }
    }

    public function testFallOneById()
    {
        $defaultArrayForTests = AppleRepositorySt::defaultArrayForTests();
        $applesService = ApplesService::createAndValidateStrictly([
            ApplesService::_unixTime => time(),
            ApplesService::_applesRepository => new AppleRepositorySt([
                AppleRepositorySt::_applesArray => AppleRepositorySt::defaultArrayForTests()
            ])
        ]);
        $applesService->fallOneById(1);
        $this->assertEquals($applesService->getAll()[1]->getStatusCode(), AppleStatusVO::STATUS_ON_THE_GROUND);
        $this->assertEquals(empty($applesService->getAll()[1]->falledAt), false);
    }

    public function testRotOneById()
    {
        $defaultArrayForTests = AppleRepositorySt::defaultArrayForTests();
        $applesService = ApplesService::createAndValidateStrictly([
            ApplesService::_unixTime => time(),
            ApplesService::_applesRepository => new AppleRepositorySt([
                AppleRepositorySt::_applesArray => $defaultArrayForTests
            ])
        ]);
        $applesService->fallOneById(1);
        $applesService->rotOneById(1);
        $this->assertEquals($applesService->getAll()[1]->getStatusCode(), AppleStatusVO::STATUS_ROTTEN);
        $this->assertEquals(empty($applesService->getAll()[1]->falledAt), false);
    }

    public function testDeleteOneById()
    {
        $defaultArrayForTests = AppleRepositorySt::defaultArrayForTests();
        $applesService = ApplesService::createAndValidateStrictly([
            ApplesService::_unixTime => time(),
            ApplesService::_applesRepository => new AppleRepositorySt([
                AppleRepositorySt::_applesArray => $defaultArrayForTests
            ])
        ]);
        $this->assertEquals(isset($applesService->getAll()[2]), true);
        $applesService->deleteOneById(2);
        $this->assertEquals(isset($applesService->getAll()[2]), false);
    }
}