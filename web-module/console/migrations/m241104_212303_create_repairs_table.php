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
class m241104_212303_create_repairs_table extends Migration
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
        
        $this->createTable('{{%repairs}}', [
            'id' => $this->primaryKey(),
            'device' => "ENUM('Computer', 'Phone', 'Tablet', 'Wearable') NOT NULL",
            'progress' => "ENUM('Created','Pending Acceptance','Denied','In Progress','Completed') NOT NULL DEFAULT 'Created'",
            'repairman_id' => $this->integer()->notNull(),
            'client_id' => $this->integer()->notNull(),
            'invoice_id' => $this->integer(),
            'hours_spent_working' => $this->integer()->defaultValue(0),
            'description' => $this->text()->notNull(),
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
            'RESTRICT'
        );

        // creates index for column `repairman_id`
        $this->createIndex(
            '{{%idx-repairs-invoice_id}}',
            '{{%repairs}}',
            'invoice_id'
        );

        // add foreign key for table `{{%repairman}}`
        $this->addForeignKey(
            '{{%fk-repairs-invoice_id}}',
            '{{%repairs}}',
            'invoice_id',
            '{{%invoices}}',
            'id',
            'RESTRICT'
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
            'RESTRICT'
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

        // drops foreign key for table `{{%repairman}}`
        $this->dropForeignKey(
            '{{%fk-repairs-invoice_id}}',
            '{{%repairs}}'
        );

        // drops index for column `repairman_id`
        $this->dropIndex(
            '{{%idx-repairs-invoice_id}}',
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

        $this->dropTable('{{%repairs}}');
    }
}
