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
}