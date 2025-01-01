<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%favorite_products}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%products}}`
 * - `{{%users}}`
 */
class m241101_042941_create_favorite_products_table extends Migration
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

        $this->createTable('{{%favorite_products}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
        ]);

        // creates index for column `product_id`
        $this->createIndex(
            '{{%idx-favorite_products-product_id}}',
            '{{%favorite_products}}',
            'product_id'
        );

        // add foreign key for table `{{%products}}`
        $this->addForeignKey(
            '{{%fk-favorite_products-product_id}}',
            '{{%favorite_products}}',
            'product_id',
            '{{%products}}',
            'id',
            'RESTRICT'
        );

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-favorite_products-user_id}}',
            '{{%favorite_products}}',
            'user_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-favorite_products-user_id}}',
            '{{%favorite_products}}',
            'user_id',
            '{{%user}}',
            'id',
            'RESTRICT'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%products}}`
        $this->dropForeignKey(
            '{{%fk-favorite_products-product_id}}',
            '{{%favorite_products}}'
        );

        // drops index for column `product_id`
        $this->dropIndex(
            '{{%idx-favorite_products-product_id}}',
            '{{%favorite_products}}'
        );

        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-favorite_products-user_id}}',
            '{{%favorite_products}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-favorite_products-user_id}}',
            '{{%favorite_products}}'
        );

        $this->dropTable('{{%favorite_products}}');
    }
}
