<?php

use yii\db\Migration;

/**
 * Class m220308_105038_add_user
 */
class m220308_105038_add_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $user = new \common\models\User();
        $user->username = 'user';
        $user->email = 'tostar74@mail.ru';
        $user->status = \common\models\User::STATUS_ACTIVE;
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        $user->generatePasswordResetToken();
        $user->setPassword('user');
        $user->save();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        \common\models\User::deleteAll();
    }

}
