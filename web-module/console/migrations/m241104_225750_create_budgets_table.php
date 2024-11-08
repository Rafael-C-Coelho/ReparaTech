<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%budgets}}`.
 */
class m241104_225750_create_budgets_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%budgets}}', [
            'id' => $this->primaryKey(),
            'value' => $this->DECIMAL(8,2)->notNull(),
            'date' => $this->DATE()->notNull(),
            'time' => $this->TIME()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%budgets}}');
    }
}
