<?php

use yii\db\Migration;

/**
 * Class m241012_162922_add_user_roles
 */
class m241012_162922_add_user_roles extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'role', $this->string()->notNull());
        $this->addColumn('user', 'name', $this->string()->notNull());
        $this->addColumn('user', 'nif', $this->string()->null()); // For client
        $this->addColumn('user', 'contact', $this->string()->null()); // For client
        $this->addColumn('user', 'address', $this->string()->null()); // For client
        $this->addColumn('user', 'value', $this->decimal(10, 2)->null()); // For repairman
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user', 'role');
        $this->dropColumn('user', 'name');
        $this->dropColumn('user', 'nif');
        $this->dropColumn('user', 'contact');
        $this->dropColumn('user', 'address');
        $this->dropColumn('user', 'value');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241012_162922_add_user_roles cannot be reverted.\n";

        return false;
    }
    */
}
