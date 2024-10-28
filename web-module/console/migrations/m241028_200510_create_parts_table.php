<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%parts}}`.
 */
class m241028_200510_create_parts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%parts}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'stock' => $this->integer()->notNull()->unsigned(),
            'price' => $this->decimal(10, 2)->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%parts}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241028_200510_create_partsTable cannot be reverted.\n";

        return false;
    }
    */
}
