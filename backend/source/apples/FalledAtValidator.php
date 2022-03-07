<?php

namespace backend\source\apples;

use yii\validators\Validator;

class FalledAtValidator extends Validator
{
    const _statusAttributeName = 'statusAttributeName';
    const _createdAtAttributeName = 'createdAtAttributeName';

    public $statusAttributeName;
    public $createdAtAttributeName;

    public function validateAttribute($model, $attribute)
    {
        /* @var AppleStatusVO $model->$statusAttribute */
        $statusAttribute = $this->statusAttributeName;
        $createdAtAttributeName = $this->createdAtAttributeName;
        if(!$this->statusAttributeName) {
            $model->addError($attribute, "В валидаторе Параметра FallenAt должен быть указан дополнительный"
                . " параметр statusAttribute");
        }
        if(!$this->createdAtAttributeName) {
            $model->addError($attribute, "В валидаторе Параметра FallenAt должен быть указан дополнительный"
                . " параметр createdAtAttributeName");
        }
        if(!is_a($model->$statusAttribute, AppleStatusVO::class)) {
            $model->addError($attribute, "В валидаторе Параметра FallenAt дополнительный параметр statusAttribute"
                . " должен указывать на аттрибут модели класса AppleStatusVO, получен объект класса "
                . get_class($model->$statusAttribute));
        }
        if(($model->$attribute) && ($model->$statusAttribute->statusCode == AppleStatusVO::STATUS_ON_THE_TREE)) {
            $model->addError($attribute, "Ошибка валидации: яблоко имеет время падения, но статус, что висит на ветке");
        }
        if(($model->$createdAtAttributeName) && ($model->$attribute < $model->$createdAtAttributeName)) {
            $model->addError($attribute, 'Яблоко не может упасть раньше, чем было создано');
        }
    }
}