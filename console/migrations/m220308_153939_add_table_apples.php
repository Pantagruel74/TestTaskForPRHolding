<?php

use yii\db\Migration;
use backend\infrastructure\db\AppleAr;

/**
 * Class m220308_153939_add_table_apples
 */
class m220308_153939_add_table_apples extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(AppleAr::tableName(), [
            AppleAr::_id => $this->primaryKey(),
            AppleAr::_color => $this->string(6)->notNull(),
            AppleAr::_createdAt => $this->bigInteger()->notNull(),
            AppleAr::_falledAt => $this->bigInteger(),
            AppleAr::_status => $this->smallInteger(),
            AppleAr::_eatenPercent => $this->double()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(AppleAr::tableName());
    }

}
