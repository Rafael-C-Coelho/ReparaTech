<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%repairmans}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 */
class m241107_022312_create_repairmans_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%repairmans}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'name' => $this->string(256),
            'value' => $this->decimal(8,2),
            'password' => $this->string(256),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-repairmans-user_id}}',
            '{{%repairmans}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-repairmans-user_id}}',
            '{{%repairmans}}',
            'user_id',
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
            '{{%fk-repairmans-user_id}}',
            '{{%repairmans}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-repairmans-user_id}}',
            '{{%repairmans}}'
        );

        $this->dropTable('{{%repairmans}}');
    }
}
