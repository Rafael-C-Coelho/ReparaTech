<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%sales}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%clients}}`
 * - `{{%invoices}}`
 */
class m241107_015815_create_sales_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%sales}}', [
            'id' => $this->primaryKey(),
            'client_id' => $this->integer()->notNull(),
            'invoice_id' => $this->integer()->notNull(),
        ]);

        // creates index for column `client_id`
        $this->createIndex(
            '{{%idx-sales-client_id}}',
            '{{%sales}}',
            'client_id'
        );

        // add foreign key for table `{{%clients}}`
        $this->addForeignKey(
            '{{%fk-sales-client_id}}',
            '{{%sales}}',
            'client_id',
            '{{%user}}',
            'id',
            'RESTRICT'
        );

        // creates index for column `invoice_id`
        $this->createIndex(
            '{{%idx-sales-invoice_id}}',
            '{{%sales}}',
            'invoice_id'
        );

        // add foreign key for table `{{%invoices}}`
        $this->addForeignKey(
            '{{%fk-sales-invoice_id}}',
            '{{%sales}}',
            'invoice_id',
            '{{%invoices}}',
            'id',
            'RESTRICT'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%clients}}`
        $this->dropForeignKey(
            '{{%fk-sales-client_id}}',
            '{{%sales}}'
        );

        // drops index for column `client_id`
        $this->dropIndex(
            '{{%idx-sales-client_id}}',
            '{{%sales}}'
        );

        // drops foreign key for table `{{%invoices}}`
        $this->dropForeignKey(
            '{{%fk-sales-invoice_id}}',
            '{{%sales}}'
        );

        // drops index for column `invoice_id`
        $this->dropIndex(
            '{{%idx-sales-invoice_id}}',
            '{{%sales}}'
        );

        $this->dropTable('{{%sales}}');
    }
}
