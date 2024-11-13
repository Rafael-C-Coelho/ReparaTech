<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%invoices}}`.
 */
class m241104_230401_create_invoices_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%invoices}}', [
            'id' => $this->primaryKey(),
            'date' => $this->DATE()->notNull(),
            'time' => $this->TIME()->notNull(),
            'client_id' => $this->integer()->notNull(),
            'repair_id' => $this->integer()->notNull(),
            'total' => $this->DECIMAL(8,2)->notNull(),
        ]);

        $this->createIndex(
            '{{%idx-invoices-client_id}}',
            '{{%invoices}}',
            'client_id'
        );

        $this->addForeignKey(
            '{{%fk-invoices-client_id}}',
            '{{%invoices}}',
            'client_id',
            '{{%user}}',
            'id',
            'RESTRICT'
        );

        $this->createIndex(
            '{{%idx-invoices-repair_id}}',
            '{{%invoices}}',
            'repair_id'
        );


        $this->addForeignKey(
            '{{%fk-invoices-repair_id}}',
            '{{%invoices}}',
            'repair_id',
            '{{%repairs}}',
            'id',
            'RESTRICT'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            '{{%fk-invoices-client_id}}',
            '{{%invoices}}'
        );

        $this->dropIndex(
            '{{%idx-invoices-client_id}}',
            '{{%invoices}}'
        );

        $this->dropTable('{{%invoices}}');
    }
}
