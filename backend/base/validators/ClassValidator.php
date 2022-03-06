<?php
namespace backend\base\validators;

use yii\validators\Validator;

/**
 * Валидатор проверки соответствия аттрибута классу
 */
class ClassValidator extends Validator
{
    const _expected = 'expected';

    public $expected;

    public function validateAttribute($model, $attribute)
    {
        if(empty($this->expected)) {
            throw new \ErrorException('В валидаторе isObjectOfClass объекта ' . get_class($model) . ' не указан ожидаемый класс');
        }
        if(!is_a($model->$attribute, $this->expected)) {
            $this->addError($model, $attribute, 'Свойство ' . $attribute
                . ' должно быть класса ' . $this->expected . ', получен объект: ' . print_r($model->$attribute, true));
        }
    }
}