<?php

use yii\db\Migration;

class m180205_122232_init_user_table extends Migration {

    public function safeUp() {

        $this->insert('user', [
            'username'      => 'admin',
            'first_name'    => 'Administrador',
            'last_name'     => 'Local',
            'email'         => 'admin@yii.local.cat',
            'status'        => 10,
            'password_hash' => '$2y$13$PNDcAM2m9cFmzanrk4Dpf.rb3zt5ehEmPszz4zcs8tXGA943E8Fcy',
            'created_at'    => '2018-02-05 12:00:00',
            'updated_at'    => '2018-02-05 12:00:00',
        ]);

    }

    public function safeDown() {
        $this->truncateTable('user');
    }

}
