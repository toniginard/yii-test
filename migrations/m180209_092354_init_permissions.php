<?php

use yii\db\Migration;

/**
 * Class m180209_092354_init_permissions
 */
class m180209_092354_init_permissions extends Migration
{
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        $permRead = $auth->createPermission('readUsers');
        $permRead->description = 'Read access to Users table';
        $auth->add($permRead);

        $permWrite = $auth->createPermission('writeUsers');
        $permWrite->description = 'Write access to Users table';
        $auth->add($permWrite);
        $auth->addChild($permWrite, $permRead);

        $roleAdmin = $auth->getRole('Administrador');
        $auth->addChild($roleAdmin, $permWrite);

        $user = User::findOne()->where(['username' => 'toni']);
        $auth->assign($roleAdmin, $user->getId());

    }

    public function safeDown()
    {
        $auth = Yii::$app->authManager;

        $permission = $auth->getPermission('readUsers');
        $auth->remove($permission);

        $permission = $auth->getPermission('writeUsers');
        $auth->remove($permission);

        return true;
    }

}
