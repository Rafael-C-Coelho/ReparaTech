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
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // https://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%comments}}', [
            'id' => $this->primaryKey(),
            'repair_id' => $this->integer()->notNull(),
            'description' => $this->text()->notNull(),
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
