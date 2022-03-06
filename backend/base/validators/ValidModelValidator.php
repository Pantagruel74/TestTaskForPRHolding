<?php
namespace backend\base\validators;

use yii\validators\Validator;

use yii\base\Model;

/**
 * Валидатор проверки соответствия аттрибута классу
 */
class ValidModelValidator extends Validator
{
    public function validateAttribute($model, $attribute)
    {
        if(!is_subclass_of($model->$attribute, Model::class)) {
            $this->addError($model, $attribute, 'Свойство ' . $attribute
                . ' должно быть класса yii\base\Model, получен объект: ' . print_r($model->$attribute, true));
        } else {
            if (!$model->$attribute->validate()) {
                $this->addError($model, $attribute, 'Аттрибут ' . $attribute
                    . ' не прошел валидацию: ' . $model->$attribute->getFirstErrors());
            }
        }
    }
}