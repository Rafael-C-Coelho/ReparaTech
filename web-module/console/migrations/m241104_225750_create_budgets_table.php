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
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // https://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%budgets}}', [
            'id' => $this->primaryKey(),
            'value' => $this->DECIMAL(8,2)->notNull(),
            'date' => $this->DATE()->notNull(),
            'client_id' => $this->integer()->notNull(),
            'hours_estimated_working' => $this->integer()->notNull(),
            'repairman_id' => $this->integer()->notNull(),
            'repair_id' => $this->integer()->notNull(),
            'time' => $this->TIME()->notNull(),
            'description' => $this->text()->notNull(),
            'status' => 'ENUM("Pending", "Approved", "Rejected") DEFAULT "Pending"',
        ]);

        // creates index for column `client_id`
        $this->createIndex(
            '{{%idx-budgets-client_id}}',
            '{{%budgets}}',
            'client_id'
        );

        // add foreign key for table `{{%client}}`
        $this->addForeignKey(
            '{{%fk-budgets-client_id}}',
            '{{%budgets}}',
            'client_id',
            '{{%user}}',
            'id',
            'RESTRICT'
        );

        // creates index for column `client_id`
        $this->createIndex(
            '{{%idx-budgets-repairman_id}}',
            '{{%budgets}}',
            'repairman_id'
        );

        // add foreign key for table `{{%client}}`
        $this->addForeignKey(
            '{{%fk-budgets-repairman_id}}',
            '{{%budgets}}',
            'repairman_id',
            '{{%user}}',
            'id',
            'RESTRICT'
        );

        $this->createIndex(
            '{{%idx-budgets-repair_id}}',
            '{{%budgets}}',
            'repair_id'
        );


        $this->addForeignKey(
            '{{%fk-budgets-repair_id}}',
            '{{%budgets}}',
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
            '{{%fk-budgets-repairman_id}}',
            '{{%budgets}}'
        );

        $this->dropIndex(
            '{{%idx-budgets-repairman_id}}',
            '{{%budgets}}'
        );

        $this->dropForeignKey(
            '{{%fk-budgets-client_id}}',
            '{{%budgets}}'
        );

        $this->dropIndex(
            '{{%idx-budgets-client_id}}',
            '{{%budgets}}'
        );

        $this->dropTable('{{%budgets}}');
    }
}
