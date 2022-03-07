<?php

namespace backend\source\apples;

use yii\validators\Validator;

class FalledAtValidator extends Validator
{
    const _statusAttributeName = 'statusAttributeName';

    public $statusAttributeName;

    public function validateAttribute($model, $attribute)
    {
        /* @var AppleStatusVO $model->$statusAttribute */
        $statusAttribute = $this->statusAttributeName;
        if(!$this->statusAttributeName) {
            $model->addError($attribute, "В валидаторе Параметра FallenAt должен быть указан дополнительный"
                . " параметр statusAttribute");
        }
        if(!is_a($model->$statusAttribute, AppleStatusVO::class)) {
            $model->addError($attribute, "В валидаторе Параметра FallenAt дополнительный параметр statusAttribute"
                . " должен указывать на аттрибут модели класса AppleStatusVO, получен объект класса "
                . get_class($model->$statusAttribute));
        }
        if(($model->$attribute) && ($model->$statusAttribute->statusCode == AppleStatusVO::STATUS_ON_THE_TREE)) {
            $model->addError($attribute, "Ошибка валидации: яблоко имеет время падения, но статус, что висит на ветке");
        }
    }
}