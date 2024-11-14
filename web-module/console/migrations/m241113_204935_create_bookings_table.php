<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%bookings}}`.
 */
class m241113_204935_create_bookings_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%bookings}}', [
            'id' => $this->primaryKey(),
            'repair_id' => $this->integer()->notNull(),
            'date' => $this->date()->notNull(),
            'time' => $this->time()->notNull(),
            'status' => "ENUM('Requested', 'Confirmed', 'Denied', 'Cancelled') NOT NULL DEFAULT 'Requested'",
        ]);


        // creates index for column `repair_id`
        $this->createIndex(
            '{{%idx-bookings-repair_id}}',
            '{{%bookings}}',
            'repair_id'
        );

        // add foreign key for table `{{%repairs}}`
        $this->addForeignKey(
            '{{%fk-bookings-repair_id}}',
            '{{%bookings}}',
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
        // drops foreign key for table `{{%sales}}`
        $this->dropForeignKey(
            '{{%fk-bookings-repair_id}}',
            '{{%bookings}}'
        );

        // drops index for column `repair_id`
        $this->dropIndex(
            '{{%idx-bookings-repair_id}}',
            '{{%bookings}}'
        );

        $this->dropTable('{{%bookings}}');

    }
}
