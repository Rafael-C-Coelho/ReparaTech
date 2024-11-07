<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%comments}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%repairs}}`
 */
class m241107_021439_create_comments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%comments}}', [
            'id' => $this->primaryKey(),
            'repair_id' => $this->integer()->notNull(),
            'photo' => $this->binary(),
            'description' => $this->string(512),
        ]);

        // creates index for column `repair_id`
        $this->createIndex(
            '{{%idx-comments-repair_id}}',
            '{{%comments}}',
            'repair_id'
        );

        // add foreign key for table `{{%repairs}}`
        $this->addForeignKey(
            '{{%fk-comments-repair_id}}',
            '{{%comments}}',
            'repair_id',
            '{{%repairs}}',
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
            '{{%fk-comments-repair_id}}',
            '{{%comments}}'
        );

        // drops index for column `repair_id`
        $this->dropIndex(
            '{{%idx-comments-repair_id}}',
            '{{%comments}}'
        );

        $this->dropTable('{{%comments}}');
    }
}
