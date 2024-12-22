<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%products}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%suppliers}}`
 * - `{{%product_categorys}}`
 */
class m241028_201639_create_products_table extends Migration
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

        $this->createTable('{{%products}}', [
            'id' => $this->primaryKey(),
            'name' => $this->text()->notNull(),
            // 'description' => $this->text()->notNull(),
            'price' => $this->decimal()->notNull(),
            'stock' => $this->integer()->unsigned()->notNull(),
            'supplier_id' => $this->integer()->notNull(),
            'category_id' => $this->integer()->notNull(),
            'image' => $this->text(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ], $tableOptions);

        // creates index for column `supplier_id`
        $this->createIndex(
            '{{%idx-products-supplier_id}}',
            '{{%products}}',
            'supplier_id'
        );

        $this->createIndex(
            '{{%idx-products-category_id}}',
            '{{%products}}',
            'category_id'
        );

        // add foreign key for table `{{%suppliers}}`
        $this->addForeignKey(
            '{{%fk-products-supplier_id}}',
            '{{%products}}',
            'supplier_id',
            '{{%suppliers}}',
            'id',
            'RESTRICT'
        );

        $this->addForeignKey(
            '{{%fk-products-category_id}}',
            '{{%products}}',
            'category_id',
            '{{%product_categorys}}',
            'id',
            'RESTRICT'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%suppliers}}`
        $this->dropForeignKey(
            '{{%fk-products-supplier_id}}',
            '{{%products}}'
        );

        // drops foreign key for table `{{%product_categorys}}`
        $this->dropForeignKey(
            '{{%fk-products-category_id}}',
            '{{%products}}'
        );

        // drops index for column `supplier_id`
        $this->dropIndex(
            '{{%idx-products-supplier_id}}',
            '{{%products}}'
        );
        // drops index for column `category_id`
        $this->dropIndex(
            '{{%idx-products-category_id}}',
            '{{%products}}'
        );

        $this->dropTable('{{%products}}');
    }
}
