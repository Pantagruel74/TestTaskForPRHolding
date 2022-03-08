<?php

namespace backend\source\apples;

use backend\base\traits\ValidateStrictlyTrait;
use backend\base\validators\SubclassValidator;
use backend\base\validators\ValidModelValidator;
use yii\base\Model;

/**
 * Сервис предоставляющий API для работы с доменным слоем "яблок"
 *
 * @property ApplesRepositoryInterface $applesRepository
 * @property int $unixTime
 */
class ApplesService extends Model
{
    use ValidateStrictlyTrait;

    /**
     * =================================================================================================================
     * Свойства
     */

    const _applesRepository = 'applesRepository';
    const _unixTime = 'unixTime';

    public $applesRepository;
    public $unixTime;

    /**
     * =================================================================================================================
     * Правила валидации
     */

    public function rules():array
    {
        return [
            [static::_applesRepository, 'required'],
            [static::_applesRepository, SubclassValidator::class, SubclassValidator::_expected => ApplesRepositoryInterface::class],
            [static::_applesRepository, ValidModelValidator::class],
            [static::_unixTime, 'integer'],
            [static::_unixTime, 'required'],
        ];
    }

    /**
     * =================================================================================================================
     * Логика
     */

    /**
     * Получить все яблоки
     *
     * @return mixed
     */
    public function getAll()
    {
        return $this->applesRepository->getAll();
    }

    /**
     * Создать 10 новых случайных яблок
     *
     * @return void
     * @throws \Exception
     */
    public function resetAppleByRandomNum()
    {
        $this->applesRepository->deleteAll();
        $apples = [];
        for($i = 0; $i < random_int(2, 10); $i++)
        {
            $apples[$i] = AppleEn::createAndValidateStrictly([
                AppleEn::_id => $i + 1,
                AppleEn::_color => AppleColorVO::createRandomNew(),
                AppleEn::_createdAt => $this->unixTime,
                AppleEn::_status => AppleStatusVO::createAndValidateStrictly([
                    AppleStatusVO::_statusCode => AppleStatusVO::STATUS_ON_THE_TREE,
                ]),
                AppleEn::_falledAt => null,
                AppleEn::_eatenPercent => 0,
            ]);
        }
        $this->applesRepository->saveMany($apples);
    }

    public function deleteAll()
    {
        $this->applesRepository->deleteAll();
    }

    public function fallOneById($id)
    {
        $appleEn = $this->applesRepository->getOneById($id);
        $appleEn->fall();
        $this->applesRepository->saveOne($appleEn);
    }

    public function rotOneById($id)
    {
        $appleEn = $this->applesRepository->getOneById($id);
        $appleEn->rot();
        $this->applesRepository->saveOne($appleEn);
    }

}