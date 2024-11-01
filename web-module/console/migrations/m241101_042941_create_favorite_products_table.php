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
            'CASCADE'
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
            'CASCADE'
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
