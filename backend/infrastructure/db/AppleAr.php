<?php

namespace backend\infrastructure\db;

use yii\db\ActiveRecord;

class AppleAr extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%apples}}';
    }

    const _id = 'id';
    const _color = 'color';
    const _createdAt = 'createdAt';
    const _falledAt = 'falledAt';
    const _status = 'status';
    const _eatenPercent = 'eatenPercent';
}