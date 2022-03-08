<?php

use yii\db\Migration;

/**
 * Class m220308_110112_add_auth_roles
 */
class m220308_110112_add_auth_roles extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();
        $userRole = $auth->createRole('user');
        $auth->add($userRole);
        $auth->assign($userRole, 1);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();
    }

}
