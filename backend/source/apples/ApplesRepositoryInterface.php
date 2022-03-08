<?php

namespace backend\source\apples;

interface ApplesRepositoryInterface
{
    /**
     * Получить все сохраненные сущности
     *
     * @return array
     * @throws \ErrorException
     */
    public function getAll();

    /**
     * Удалить все сущности
     *
     * @return void
     */
    public function deleteAll();

    /**
     * Сохранить несколько сущностей
     *
     * @param $apples
     * @return void
     * @throws \yii\db\StaleObjectException
     */
    public function saveMany($apples);

    /**
     * Получить сущность по ID
     *
     * @param $id
     * @return AppleEn
     * @throws \ErrorException
     */
    public function getOneById($id);

    /**
     * Сохранить/обновить одну сущность
     *
     * @param $apple
     * @return void
     * @throws \yii\db\StaleObjectException
     */
    public function saveOne($apple);

    /**
     * Удалить одну сущность по ID
     *
     * @param $id
     * @return void
     * @throws \yii\db\StaleObjectException
     */
    public function deleteOneById($id);

    /**
     * Проверить все записи на время загнивания
     *
     * @param $time
     * @return void
     */
    public function checkAllToRotTime($time);
}