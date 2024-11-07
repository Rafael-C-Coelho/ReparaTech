<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%repairs}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%repairman}}`
 * - `{{%client}}`
 * - `{{%budget}}`
 * - `{{%invoice}}`
 */
class m241104_232303_create_repairs_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%repairs}}', [
            'id' => $this->primaryKey(),
            'device' => "ENUM('Computer', 'Phone', 'Tablet', 'Wearable')",
            'progress' => "ENUM('Created','Pending Acceptance','Denied','In Progress','Completed')",
            'repairman_id' => $this->integer()->notNull(),
            'client_id' => $this->integer()->notNull(),
            'budget_id' => $this->integer()->notNull(),
            'invoice_id'=> $this->integer()->notNull()
        ]);

        // creates index for column `repairman_id`
        $this->createIndex(
            '{{%idx-repairs-repairman_id}}',
            '{{%repairs}}',
            'repairman_id'
        );

        // add foreign key for table `{{%repairman}}`
        $this->addForeignKey(
            '{{%fk-repairs-repairman_id}}',
            '{{%repairs}}',
            'repairman_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `client_id`
        $this->createIndex(
            '{{%idx-repairs-client_id}}',
            '{{%repairs}}',
            'client_id'
        );

        // add foreign key for table `{{%client}}`
        $this->addForeignKey(
            '{{%fk-repairs-client_id}}',
            '{{%repairs}}',
            'client_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `budget_id`
        $this->createIndex(
            '{{%idx-repairs-budget_id}}',
            '{{%repairs}}',
            'budget_id'
        );

        // add foreign key for table `{{%budget}}`
        $this->addForeignKey(
            '{{%fk-repairs-budget_id}}',
            '{{%repairs}}',
            'budget_id',
            '{{%budgets}}',
            'id',
            'CASCADE'
        );

        // creates index for column `invoice_id`
        $this->createIndex(
            '{{%idx-repairs-invoice_id}}',
            '{{%repairs}}',
            'invoice_id'
        );

        // add foreign key for table `{{%invoice}}`
        $this->addForeignKey(
            '{{%fk-repairs-invoice_id}}',
            '{{%repairs}}',
            'invoice_id',
            '{{%invoices}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%repairman}}`
        $this->dropForeignKey(
            '{{%fk-repairs-repairman_id}}',
            '{{%repairs}}'
        );

        // drops index for column `repairman_id`
        $this->dropIndex(
            '{{%idx-repairs-repairman_id}}',
            '{{%repairs}}'
        );

        // drops foreign key for table `{{%client}}`
        $this->dropForeignKey(
            '{{%fk-repairs-client_id}}',
            '{{%repairs}}'
        );

        // drops index for column `client_id`
        $this->dropIndex(
            '{{%idx-repairs-client_id}}',
            '{{%repairs}}'
        );

        // drops foreign key for table `{{%budget}}`
        $this->dropForeignKey(
            '{{%fk-repairs-budget_id}}',
            '{{%repairs}}'
        );

        // drops index for column `budget_id`
        $this->dropIndex(
            '{{%idx-repairs-budget_id}}',
            '{{%repairs}}'
        );

        // drops foreign key for table `{{%invoice}}`
        $this->dropForeignKey(
            '{{%fk-repairs-invoice_id}}',
            '{{%repairs}}'
        );

        // drops index for column `invoice_id`
        $this->dropIndex(
            '{{%idx-repairs-invoice_id}}',
            '{{%repairs}}'
        );

        $this->dropTable('{{%repairs}}');
    }
}
