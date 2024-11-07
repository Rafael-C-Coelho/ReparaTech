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
            'sender_id' => $this->integer()->notNull(),
            'recipient_id' => $this->integer()->notNull(),
            'value' => $this->decimal(8,2),
            'date' => $this->date(),
            'time' => $this->time(),
        ]);

        // creates index for column `sender_id`
        $this->createIndex(
            '{{%idx-comments-sender_id}}',
            '{{%comments}}',
            'sender_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-comments-sender_id}}',
            '{{%comments}}',
            'sender_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `recipient_id`
        $this->createIndex(
            '{{%idx-comments-recipient_id}}',
            '{{%comments}}',
            'recipient_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-comments-recipient_id}}',
            '{{%comments}}',
            'recipient_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-comments-sender_id}}',
            '{{%comments}}'
        );

        // drops index for column `sender_id`
        $this->dropIndex(
            '{{%idx-comments-sender_id}}',
            '{{%comments}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-comments-recipient_id}}',
            '{{%comments}}'
        );

        // drops index for column `recipient_id`
        $this->dropIndex(
            '{{%idx-comments-recipient_id}}',
            '{{%comments}}'
        );

        $this->dropTable('{{%comments}}');
    }
}
