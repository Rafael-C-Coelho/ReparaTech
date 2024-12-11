<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%comments}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 * - `{{%user}}`
 */
class m241107_212352_create_comments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%comments}}', [
            'id' => $this->primaryKey(),
            'repair_id' => $this->integer()->notNull(),
            'description' => $this->text()->notNull(),
            'photo' => $this->text(),
            'date' => $this->date()->notNull(),
            'time' => $this->time()->notNull(),
        ]);

        // creates index for column `sender_id`
        $this->createIndex(
            '{{%idx-comments-repair_id}}',
            '{{%comments}}',
            'repair_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-comments-repair_id}}',
            '{{%comments}}',
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
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-comments-repair_id}}',
            '{{%comments}}'
        );

        // drops index for column `sender_id`
        $this->dropIndex(
            '{{%idx-comments-repair_id}}',
            '{{%comments}}'
        );

        $this->dropTable('{{%comments}}');
    }
}
