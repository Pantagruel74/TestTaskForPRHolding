<?php

namespace backend\base\traits;

/**
 * Трейт добавляющий объекту строгую валидацию.
 * ВНИМАНИЕ!!! Добавлять только к объектам - наследникам класса yii\base\Model
 */
trait ValidateStrictlyTrait
{
    /**
     * Строгая валидация
     *
     * @return void
     */
    public function validateStrictly() {
        if(!$this->validate()) {
            throw new \InvalidArgumentException('Ошибка валидации ' . get_class($this) . ': ' . implode(', ', $this->getErrorSummary(true)));
        }
    }

    /**
     * Загрузить и строго провалидировать
     *
     * @param $loadData
     * @return void
     */
    public function loadStrictly($loadData) {
        if(!$this->load($loadData)) {
            throw new \InvalidArgumentException('Ошибка загрузки ' . get_class($this) . ': ' . implode(', ', $this->getErrorSummary(true)));
        }
        $this->validateStrictly();
    }

    /**
     * Создать и строго провалидировать
     *
     * @param $params
     * @return static
     */
    public static function createAndValidateStrictly($params)
    {
        $newOne = new static($params);
        $newOne->validateStrictly();
        return $newOne;
    }
}