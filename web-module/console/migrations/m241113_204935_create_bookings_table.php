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
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // https://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

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
