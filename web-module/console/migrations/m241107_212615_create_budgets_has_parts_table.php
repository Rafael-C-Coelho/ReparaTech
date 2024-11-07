<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%budgets_has_parts}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%budgets}}`
 * - `{{%parts}}`
 */
class m241107_212615_create_budgets_has_parts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%budgets_has_parts}}', [
            'id' => $this->primaryKey(),
            'budget_id' => $this->integer()->notNull(),
            'part_id' => $this->integer()->notNull(),
            'quantity' => $this->integer(),
        ]);

        // creates index for column `budget_id`
        $this->createIndex(
            '{{%idx-budgets_has_parts-budget_id}}',
            '{{%budgets_has_parts}}',
            'budget_id'
        );

        // add foreign key for table `{{%budgets}}`
        $this->addForeignKey(
            '{{%fk-budgets_has_parts-budget_id}}',
            '{{%budgets_has_parts}}',
            'budget_id',
            '{{%budgets}}',
            'id',
            'CASCADE'
        );

        // creates index for column `part_id`
        $this->createIndex(
            '{{%idx-budgets_has_parts-part_id}}',
            '{{%budgets_has_parts}}',
            'part_id'
        );

        // add foreign key for table `{{%parts}}`
        $this->addForeignKey(
            '{{%fk-budgets_has_parts-part_id}}',
            '{{%budgets_has_parts}}',
            'part_id',
            '{{%parts}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%budgets}}`
        $this->dropForeignKey(
            '{{%fk-budgets_has_parts-budget_id}}',
            '{{%budgets_has_parts}}'
        );

        // drops index for column `budget_id`
        $this->dropIndex(
            '{{%idx-budgets_has_parts-budget_id}}',
            '{{%budgets_has_parts}}'
        );

        // drops foreign key for table `{{%parts}}`
        $this->dropForeignKey(
            '{{%fk-budgets_has_parts-part_id}}',
            '{{%budgets_has_parts}}'
        );

        // drops index for column `part_id`
        $this->dropIndex(
            '{{%idx-budgets_has_parts-part_id}}',
            '{{%budgets_has_parts}}'
        );

        $this->dropTable('{{%budgets_has_parts}}');
    }
}
