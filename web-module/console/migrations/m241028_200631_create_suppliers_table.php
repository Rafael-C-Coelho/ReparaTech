<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%suppliers}}`.
 */
class m241028_200631_create_suppliers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%suppliers}}', [
            'id' => $this->primaryKey(),
            'name' => $this->text(),
            'contact' => $this->text(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%suppliers}}');
    }
}
