<?php

namespace backend\source\apples;

use yii\validators\Validator;

class EatenPercentValidator extends Validator
{
    const _statusAttributeName = 'statusAttributeName';

    public $statusAttributeName;

    public function validateAttribute($model, $attribute)
    {
        /* @var AppleStatusVO $model->$statusAttribute */
        $statusAttribute = $this->statusAttributeName;
        if(!$this->statusAttributeName) {
            $model->addError($attribute, "В валидаторе Параметра EatenPercent должен быть указан дополнительный"
                . " параметр statusAttribute");
        }
        if(!is_a($model->$statusAttribute, AppleStatusVO::class)) {
            $model->addError($attribute, "В валидаторе Параметра EatenPercent дополнительный параметр statusAttribute"
                . " должен указывать на аттрибут модели класса AppleStatusVO, получен объект класса "
                . get_class($model->$statusAttribute));
        }
        if(($model->$attribute > 0) && ($model->$statusAttribute->statusCode == AppleStatusVO::STATUS_ON_THE_TREE)) {
            $model->addError($attribute, "Ошибка валидации: яблоко не может быть надкусанно, но иметь статус,"
                . " что висит на ветке");
        }
    }
}