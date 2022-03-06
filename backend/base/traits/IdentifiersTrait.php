<?php

namespace backend\base\traits;

trait IdentifiersTrait
{
    /* Разделитель для комплексного идентификатора */
    public $identifierDelimeter = '_';

    abstract public function identifiers();

    /**
     * Получить комплексный идентификатор в виде строки
     *
     * @return string
     */
    public function getComplexIdentifier()
    {
        $result = [];
        foreach ($this->identifiers() as $identifier) {
            $result[] = $this->$identifier;
        }
        return implode($this->identifierDelimeter, $result);
    }

    /**
     * Одинаковые ли идентификаторы (можно ли считать экземпляром одной сущности)
     *
     * @param $objectWithIdentifier
     * @return bool
     */
    public function isIdentifiersEqual($objectWithIdentifier) {
        if(!is_a($objectWithIdentifier, get_class($this))) return false;
        foreach($this->identifiers() as $identifierAttributeName) {
            if($this->$identifierAttributeName != $objectWithIdentifier->$identifierAttributeName) {
                return false;
            }
        }
        return true;
    }

    public function isSame($entity) {
        if(!is_a($entity, get_class($this))) return false;
        foreach($this->attrinutes() as $attributeName) {
            if($this->$attributeName != $entity->$attributeName) {
                return false;
            }
        }
        return true;
    }
}