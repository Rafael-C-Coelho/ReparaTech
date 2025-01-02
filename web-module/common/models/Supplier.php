<?php

namespace common\models;

/**
 * This is the model class for table "{{%suppliers}}".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $contact
 *
 * @property Product[] $products
 */
class Supplier extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%suppliers}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'contact'], 'string'],

            // Contact information should be optional but must be valid if provided
            [['contact'], 'string', 'max' => 255],

            // Common rules
            [['name', 'contact'], 'trim'], // Removes extra spaces
            [['name', 'contact'], 'filter', 'filter' => 'strip_tags'], // Prevents HTML tags
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'contact' => 'Contact',
        ];
    }

    /**
     * Gets query for [[Products]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::class, ['supplier_id' => 'id']);
    }
}
