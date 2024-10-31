<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%products}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%suppliers}}`
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
            'price' => $this->decimal(),
            'stock' => $this->integer()->unsigned()->notNull(),
            'supplier_id' => $this->integer()->notNull(),
            'image' => $this->text(),
        ], $tableOptions);

        // creates index for column `supplier_id`
        $this->createIndex(
            '{{%idx-products-supplier_id}}',
            '{{%products}}',
            'supplier_id'
        );

        // add foreign key for table `{{%suppliers}}`
        $this->addForeignKey(
            '{{%fk-products-supplier_id}}',
            '{{%products}}',
            'supplier_id',
            '{{%suppliers}}',
            'id',
            'CASCADE'
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

        // drops index for column `supplier_id`
        $this->dropIndex(
            '{{%idx-products-supplier_id}}',
            '{{%products}}'
        );

        $this->dropTable('{{%products}}');
    }
}
