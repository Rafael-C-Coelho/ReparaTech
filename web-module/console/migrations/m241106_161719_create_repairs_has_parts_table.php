<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%repairs_has_parts}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%repairs}}`
 * - `{{%parts}}`
 */
class m241106_161719_create_repairs_has_parts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%repairs_has_parts}}', [
            'id' => $this->primaryKey(),
            'repair_id' => $this->integer()->notNull(),
            'part_id' => $this->integer()->notNull(),
        ]);

        // creates index for column `repair_id`
        $this->createIndex(
            '{{%idx-repairs_has_parts-repair_id}}',
            '{{%repairs_has_parts}}',
            'repair_id'
        );

        // add foreign key for table `{{%repairs}}`
        $this->addForeignKey(
            '{{%fk-repairs_has_parts-repair_id}}',
            '{{%repairs_has_parts}}',
            'repair_id',
            '{{%repairs}}',
            'id',
            'CASCADE'
        );

        // creates index for column `part_id`
        $this->createIndex(
            '{{%idx-repairs_has_parts-part_id}}',
            '{{%repairs_has_parts}}',
            'part_id'
        );

        // add foreign key for table `{{%parts}}`
        $this->addForeignKey(
            '{{%fk-repairs_has_parts-part_id}}',
            '{{%repairs_has_parts}}',
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
        // drops foreign key for table `{{%repairs}}`
        $this->dropForeignKey(
            '{{%fk-repairs_has_parts-repair_id}}',
            '{{%repairs_has_parts}}'
        );

        // drops index for column `repair_id`
        $this->dropIndex(
            '{{%idx-repairs_has_parts-repair_id}}',
            '{{%repairs_has_parts}}'
        );

        // drops foreign key for table `{{%parts}}`
        $this->dropForeignKey(
            '{{%fk-repairs_has_parts-part_id}}',
            '{{%repairs_has_parts}}'
        );

        // drops index for column `part_id`
        $this->dropIndex(
            '{{%idx-repairs_has_parts-part_id}}',
            '{{%repairs_has_parts}}'
        );

        $this->dropTable('{{%repairs_has_parts}}');
    }
}
