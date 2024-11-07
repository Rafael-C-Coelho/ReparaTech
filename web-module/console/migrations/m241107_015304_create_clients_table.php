<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%clients}}`.
 */
class m241107_015304_create_clients_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%clients}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(256),
            'nif' => $this->integer(9),
            'contact' => $this->integer(12),
            'address' => $this->string(256),
            'password' => $this->string(256),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%clients}}');
    }
}
