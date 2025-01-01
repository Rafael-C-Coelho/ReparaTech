<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%invoices}}`.
 */
class m241104_200401_create_invoices_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // https://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%invoices}}', [
            'id' => $this->primaryKey(),
            'date' => $this->DATE()->notNull(),
            'time' => $this->TIME()->notNull(),
            'client_id' => $this->integer()->notNull(),
            'total' => $this->DECIMAL(8,2)->notNull(),
            'pdf_file' => $this->string(),
            'items' => $this->text()->notNull(),
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
