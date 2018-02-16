<?php

use yii\db\Migration;

/**
 * Class m180202_123920_init_rbac
 */
class m180202_123920_init_rbac extends Migration {
    /**
     * @inheritdoc
     */
    public function safeUp() {

        // Doc: http://www.yiiframework.com/doc-2.0/guide-security-authorization.html#generating-rbac-data

        $auth = Yii::$app->authManager;

        // Create Roles
        $role = $auth->createRole('Administrador');
        $auth->add($role);

        $role = $auth->createRole('RSI');
        $auth->add($role);

        $role = $auth->createRole('General');
        $auth->add($role);

        $rls = $auth->createRole('RLS');
        $auth->add($rls);

        $role = $auth->createRole('RLS-Operacions');
        $auth->add($role);
        $auth->addChild($role, $rls);

        $role = $auth->createRole('RLS-Projectes');
        $auth->add($role);
        $auth->addChild($role, $rls);

        $role = $auth->createRole('RLS-Risc');
        $auth->add($role);
        $auth->addChild($role, $rls);

        $role = $auth->createRole('RLS-CN');
        $auth->add($role);
        $auth->addChild($role, $rls);

        $role = $auth->createRole('RLS-Audit');
        $auth->add($role);
        $auth->addChild($role, $rls);

        $role = $auth->createRole('RLS-Incidencies');
        $auth->add($role);
        $auth->addChild($role, $rls);

        $role = $auth->createRole('RLS-ID');
        $auth->add($role);
        $auth->addChild($role, $rls);

        $cons = $auth->createRole('Consultor');
        $auth->add($cons);

        $role = $auth->createRole('Consultor-SOC');
        $auth->add($role);
        $auth->addChild($role, $cons);

        $role = $auth->createRole('Consultor-Seguretat');
        $auth->add($role);
        $auth->addChild($role, $cons);

        $role = $auth->createRole('Consultor-Incidents');
        $auth->add($role);
        $auth->addChild($role, $cons);

        $role = $auth->createRole('Consultor-ID');
        $auth->add($role);
        $auth->addChild($role, $cons);

        $role = $auth->createRole('Consultor-Audit');
        $auth->add($role);
        $auth->addChild($role, $cons);

        $role = $auth->createRole('Consultor-CN');
        $auth->add($role);
        $auth->addChild($role, $cons);

        $role = $auth->createRole('RSA_DAT');
        $auth->add($role);

        $role = $auth->createRole('Responsable_Seguretat');
        $auth->add($role);

        $role = $auth->createRole('DPO');
        $auth->add($role);

        $role = $auth->createRole('Gestor_Solucions');
        $auth->add($role);

        $role = $auth->createRole('RSP');
        $auth->add($role);

    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        $role = $auth = Yii::$app->authManager;

        $role = $auth->removeAll();
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180202_123920_init_rbac cannot be reverted.\n";

        return false;
    }
    */
}
