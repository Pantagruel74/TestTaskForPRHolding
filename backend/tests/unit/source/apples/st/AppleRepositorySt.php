<?php

namespace backend\tests\unit\source\apples\st;

use backend\source\apples\AppleColorVO;
use backend\source\apples\AppleEn;
use backend\source\apples\ApplesRepositoryInterface;
use backend\source\apples\AppleStatusVO;
use yii\base\Model;

class AppleRepositorySt extends Model implements ApplesRepositoryInterface
{
    const _applesArray = 'applesArray';

    public $applesArray;

    public function getAll()
    {
        return $this->applesArray;
    }

    public function deleteAll()
    {
        $this->applesArray = [];
    }

    public function saveMany($apples)
    {
        foreach($apples as $apple)
        {
            /* @var AppleEn $apple */
            $this->applesArray[$apple->id] = $apple;
        }
    }


    public static function defaultArrayForTests()
    {
        return [
            1 => AppleEn::createAndValidateStrictly([
                AppleEn::_id => 1,
                AppleEn::_eatenPercent => 0,
                AppleEn::_falledAt => null,
                AppleEn::_status => AppleStatusVO::createAndValidateStrictly([
                    AppleStatusVO::_statusCode => AppleStatusVO::STATUS_ON_THE_TREE,
                ]),
                AppleEn::_createdAt => 100,
                AppleEn::_color => AppleColorVO::createByHexAndValidateStrictly('3386d3'),
            ]),
            2 => AppleEn::createAndValidateStrictly([
                AppleEn::_id => 2,
                AppleEn::_eatenPercent => 0,
                AppleEn::_falledAt => null,
                AppleEn::_status => AppleStatusVO::createAndValidateStrictly([
                    AppleStatusVO::_statusCode => AppleStatusVO::STATUS_ON_THE_TREE,
                ]),
                AppleEn::_createdAt => 102,
                AppleEn::_color => AppleColorVO::createByHexAndValidateStrictly('3557a1'),
            ]),
            3 => AppleEn::createAndValidateStrictly([
                AppleEn::_id => 3,
                AppleEn::_eatenPercent => 0,
                AppleEn::_falledAt => 200,
                AppleEn::_status => AppleStatusVO::createAndValidateStrictly([
                    AppleStatusVO::_statusCode => AppleStatusVO::STATUS_ON_THE_GROUND,
                ]),
                AppleEn::_createdAt => 110,
                AppleEn::_color => AppleColorVO::createByHexAndValidateStrictly('215651'),
            ]),
            4 => AppleEn::createAndValidateStrictly([
                AppleEn::_id => 4,
                AppleEn::_eatenPercent => 20,
                AppleEn::_falledAt => 200,
                AppleEn::_status => AppleStatusVO::createAndValidateStrictly([
                    AppleStatusVO::_statusCode => AppleStatusVO::STATUS_ON_THE_GROUND,
                ]),
                AppleEn::_createdAt => 120,
                AppleEn::_color => AppleColorVO::createByHexAndValidateStrictly('215651'),
            ]),
            5 => AppleEn::createAndValidateStrictly([
                AppleEn::_id => 5,
                AppleEn::_eatenPercent => 20,
                AppleEn::_falledAt => 300,
                AppleEn::_status => AppleStatusVO::createAndValidateStrictly([
                    AppleStatusVO::_statusCode => AppleStatusVO::STATUS_ROTTEN,
                ]),
                AppleEn::_createdAt => 300,
                AppleEn::_color => AppleColorVO::createByHexAndValidateStrictly('516548'),
            ]),
        ];
    }

    public function getOneById($id)
    {
        return $this->applesArray[$id];
    }

    public function saveOne($apple)
    {
        $this->saveMany([$apple->id => $apple]);
    }


    public function deleteOneById($id)
    {
        if(isset($this->applesArray[$id]))
        unset($this->applesArray[$id]);
    }

    public function checkAllToRotTime($time)
    {
        foreach ($this->applesArray as $appleKey => $appleVal) {
            /* @var AppleEn $appleVal */
            if(($appleVal->getStatusCode() == AppleStatusVO::STATUS_ON_THE_GROUND) && ($appleVal->falledAt < ($time - (5 * 60 * 60)))) {
                $this->applesArray[$appleKey]->status = AppleStatusVO::createAndValidateStrictly([
                    AppleStatusVO::_statusCode => AppleStatusVO::STATUS_ROTTEN,
                ]);
            }
        }
    }

}