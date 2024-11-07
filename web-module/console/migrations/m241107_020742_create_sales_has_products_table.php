<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%sales_has_products}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%sales}}`
 * - `{{%products}}`
 */
class m241107_020742_create_sales_has_products_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%sales_has_products}}', [
            'id' => $this->primaryKey(),
            'sale_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
            'quantity' => $this->integer(100),
        ]);

        // creates index for column `sale_id`
        $this->createIndex(
            '{{%idx-sales_has_products-sale_id}}',
            '{{%sales_has_products}}',
            'sale_id'
        );

        // add foreign key for table `{{%sales}}`
        $this->addForeignKey(
            '{{%fk-sales_has_products-sale_id}}',
            '{{%sales_has_products}}',
            'sale_id',
            '{{%sales}}',
            'id',
            'CASCADE'
        );

        // creates index for column `product_id`
        $this->createIndex(
            '{{%idx-sales_has_products-product_id}}',
            '{{%sales_has_products}}',
            'product_id'
        );

        // add foreign key for table `{{%products}}`
        $this->addForeignKey(
            '{{%fk-sales_has_products-product_id}}',
            '{{%sales_has_products}}',
            'product_id',
            '{{%products}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%sales}}`
        $this->dropForeignKey(
            '{{%fk-sales_has_products-sale_id}}',
            '{{%sales_has_products}}'
        );

        // drops index for column `sale_id`
        $this->dropIndex(
            '{{%idx-sales_has_products-sale_id}}',
            '{{%sales_has_products}}'
        );

        // drops foreign key for table `{{%products}}`
        $this->dropForeignKey(
            '{{%fk-sales_has_products-product_id}}',
            '{{%sales_has_products}}'
        );

        // drops index for column `product_id`
        $this->dropIndex(
            '{{%idx-sales_has_products-product_id}}',
            '{{%sales_has_products}}'
        );

        $this->dropTable('{{%sales_has_products}}');
    }
}
