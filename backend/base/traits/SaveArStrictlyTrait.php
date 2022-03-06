<?php

namespace backend\base\traits;

/**
 * Трейт строгого сохранения для ActiveRecord
 */
trait SaveArStrictlyTrait
{
    /**
     * Строгое сохранение
     *
     * @return void
     * @throws \ErrorException
     */
    public function saveStrictly()
    {
        if(!$this->save())
        {
            throw new \ErrorException('Ошибка сохранения объекта ' . get_class($this) . ': '
                . implode(', ', $this->getFirstErrors()));
        }
    }

    /**
     * Строгое обновление
     *
     * @return void
     * @throws \ErrorException
     */
    public function updateStrictly()
    {
        if(!$this->update())
        {
            throw new \ErrorException('Ошибка обновления объекта ' . get_class($this) . ': '
                . implode(', ', $this->getFirstErrors()));
        }
    }
}