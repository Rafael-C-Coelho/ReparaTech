<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%bookings}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%repairmans}}`
 * - `{{%clients}}`
 */
class m241107_023405_create_bookings_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%bookings}}', [
            'id' => $this->primaryKey(),
            'repairman_id' => $this->integer()->notNull(),
            'client_id' => $this->integer()->notNull(),
            'date' => $this->date(),
            'time' => $this->time(),
        ]);

        // creates index for column `repairman_id`
        $this->createIndex(
            '{{%idx-bookings-repairman_id}}',
            '{{%bookings}}',
            'repairman_id'
        );

        // add foreign key for table `{{%repairmans}}`
        $this->addForeignKey(
            '{{%fk-bookings-repairman_id}}',
            '{{%bookings}}',
            'repairman_id',
            '{{%repairmans}}',
            'id',
            'CASCADE'
        );

        // creates index for column `client_id`
        $this->createIndex(
            '{{%idx-bookings-client_id}}',
            '{{%bookings}}',
            'client_id'
        );

        // add foreign key for table `{{%clients}}`
        $this->addForeignKey(
            '{{%fk-bookings-client_id}}',
            '{{%bookings}}',
            'client_id',
            '{{%clients}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%repairmans}}`
        $this->dropForeignKey(
            '{{%fk-bookings-repairman_id}}',
            '{{%bookings}}'
        );

        // drops index for column `repairman_id`
        $this->dropIndex(
            '{{%idx-bookings-repairman_id}}',
            '{{%bookings}}'
        );

        // drops foreign key for table `{{%clients}}`
        $this->dropForeignKey(
            '{{%fk-bookings-client_id}}',
            '{{%bookings}}'
        );

        // drops index for column `client_id`
        $this->dropIndex(
            '{{%idx-bookings-client_id}}',
            '{{%bookings}}'
        );

        $this->dropTable('{{%bookings}}');
    }
}
