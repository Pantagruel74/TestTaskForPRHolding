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
        $this->applesRepository->checkAllToRotTime($this->unixTime);
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
        $this->applesRepository->checkAllToRotTime($this->unixTime);
    }

    /**
     * Удалить все сущности
     *
     * @return void
     */
    public function deleteAll()
    {
        $this->applesRepository->deleteAll();
        $this->applesRepository->checkAllToRotTime($this->unixTime);
    }

    /**
     * Яблоко с указанным ID упало
     *
     * @param $id
     * @return void
     * @throws \ErrorException
     * @throws \yii\db\StaleObjectException
     */
    public function fallOneById(int $id)
    {
        $appleEn = $this->applesRepository->getOneById($id);
        $appleEn->fall();
        $this->applesRepository->saveOne($appleEn);
        $this->applesRepository->checkAllToRotTime($this->unixTime);
    }

    /**
     * Яблоко с указанным ID прогнило
     *
     * @param $id
     * @return void
     * @throws \ErrorException
     * @throws \yii\db\StaleObjectException
     */
    public function rotOneById(int $id)
    {
        $appleEn = $this->applesRepository->getOneById($id);
        $appleEn->rot();
        $this->applesRepository->saveOne($appleEn);
        $this->applesRepository->checkAllToRotTime($this->unixTime);
    }

    /**
     * Удалить яблоко по ID
     *
     * @param $id
     * @return void
     * @throws \yii\db\StaleObjectException
     */
    public function deleteOneById(int $id)
    {
        $this->applesRepository->checkAllToRotTime($this->unixTime);
        $this->applesRepository->deleteOneById($id);
    }

    /**
     * Получить одну запис по ID
     *
     * @param int $id
     * @return AppleEn
     * @throws \ErrorException
     */
    public function getOneById(int $id):AppleEn
    {
        $this->applesRepository->checkAllToRotTime($this->unixTime);
        return $this->applesRepository->getOneById($id);
    }

    /**
     * откусить яблоко
     *
     * @param int $id
     * @param float $bitPercent
     * @return bool
     * @throws \ErrorException
     * @throws \yii\db\StaleObjectException
     */
    public function bitOneById(int $id, float $bitPercent):bool
    {
        $appleEn = $this->applesRepository->getOneById($id);
        $appleEn->bit($bitPercent);
        $appleToDelete = ($appleEn->getStatusCode() == AppleStatusVO::STATUS_TO_DELETE);
        $this->applesRepository->saveOne($appleEn);
        $this->applesRepository->checkAllToRotTime($this->unixTime);
        return $appleToDelete;
    }

}