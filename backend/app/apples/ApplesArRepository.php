<?php

namespace backend\app\apples;

use backend\base\traits\ValidateStrictlyTrait;
use backend\infrastructure\db\AppleAr;
use backend\source\apples\AppleColorVO;
use backend\source\apples\AppleEn;
use backend\source\apples\ApplesRepositoryInterface;
use backend\source\apples\AppleStatusVO;
use unit\source\apples\ColorVOTest;
use yii\base\Model;

/**
 * Репозиторий для получения и сохранения записей яблок в БД
 */
class ApplesArRepository extends Model implements ApplesRepositoryInterface
{
    use ValidateStrictlyTrait;

    /**
     * Получить все сохраненные сущности
     *
     * @return array
     * @throws \ErrorException
     */
    public function getAll()
    {
        $allAppleArs = AppleAr::find()
            ->all();
        $allAppleEntities= [];
        foreach ($allAppleArs as $appleAr)
        {
            $allAppleEntities[$appleAr->{AppleAr::_id}] = AppleEn::createAndValidateStrictly([
                AppleEn::_id => $appleAr->{AppleAr::_id},
                AppleEn::_color => AppleColorVO::createByHexAndValidateStrictly($appleAr->{AppleAr::_color}),
                AppleEn::_createdAt => $appleAr->{AppleAr::_createdAt},
                AppleEn::_falledAt => $appleAr->{AppleAr::_falledAt},
                AppleEn::_eatenPercent => $appleAr->{AppleAr::_eatenPercent},
                AppleEn::_status => AppleStatusVO::createAndValidateStrictly([
                    AppleStatusVO::_statusCode => $appleAr->{AppleAr::_status},
                ]),
            ]);
        }
        return $allAppleEntities;
    }

    /**
     * Удалить все сущности
     *
     * @return void
     */
    public function deleteAll()
    {
        AppleAr::deleteAll();
    }

    /**
     * Сохранить/обновить несколько сущностей
     *
     * @param $apples
     * @return void
     * @throws \yii\db\StaleObjectException
     */
    public function saveMany($apples)
    {
        foreach ($apples as $appleEn)
        {
            $appleAr = null;
            /* @var AppleEn $appleEn */
            if($appleEn->getStatusCode() == AppleStatusVO::STATUS_TO_DELETE)
            {
                $appleAr = AppleAr::find()
                    ->andWhere([AppleAr::_id => $appleEn->id])
                    ->one();
                if ($appleAr) {
                    $appleAr->delete();
                }
            } else {
                $appleEn->validateStrictly();
                $appleAr = AppleAr::find()
                    ->andWhere([AppleAr::_id => $appleEn->id])
                    ->one();
                if (!$appleAr) {
                    $appleAr = new AppleAr();
                }
                $appleAr->{AppleAr::_status} = $appleEn->getStatusCode();
                $appleAr->{AppleAr::_eatenPercent} = $appleEn->eatenPercent;
                $appleAr->{AppleAr::_falledAt} = $appleEn->falledAt;
                $appleAr->{AppleAr::_createdAt} = $appleEn->createdAt;
                $appleAr->{AppleAr::_color} = $appleEn->color->getHex();
                $appleAr->save();
            }
        }
    }

    /**
     * Получить сущность по ID
     *
     * @param $id
     * @return AppleEn
     * @throws \ErrorException
     */
    public function getOneById($id)
    {
        $appleAr = AppleAr::find()
            ->andWhere([AppleAr::_id => $id])
            ->one();
        if(!$appleAr) {
            throw new \InvalidArgumentException('В БД записи яблока с ID=' . $id . ' не существует');
        }
        return AppleEn::createAndValidateStrictly([
            AppleEn::_id => $appleAr->{AppleAr::_id},
            AppleEn::_createdAt => $appleAr->{AppleAr::_createdAt},
            AppleEn::_falledAt => $appleAr->{AppleAr::_falledAt},
            AppleEn::_eatenPercent => $appleAr->{AppleAr::_eatenPercent},
            AppleEn::_color => AppleColorVO::createByHexAndValidateStrictly($appleAr->{AppleAr::_color}),
            AppleEn::_status => AppleStatusVO::createAndValidateStrictly([
                AppleStatusVO::_statusCode => $appleAr->{AppleAr::_status}
            ]),
        ]);
    }

    /**
     * Удалить одну сущность по ID
     *
     * @param $id
     * @return void
     * @throws \yii\db\StaleObjectException
     */
    public function deleteOneById($id)
    {
        $appleAr = AppleAr::find()
            ->andWhere([AppleAr::_id => $id])
            ->one();
        if(!$appleAr) {
            throw new \InvalidArgumentException('В БД записи яблока с ID=' . $id . ' не существует');
        }
        $appleAr->delete();
    }

    /**
     * Сохранить/обновить одну сущность
     *
     * @param $apple
     * @return void
     * @throws \yii\db\StaleObjectException
     */
    public function saveOne($apple)
    {
        $this->saveMany([$apple->id => $apple]);
    }
}