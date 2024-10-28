<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%products}}".
 *
 * @property int $id
 * @property float|null $price
 * @property int $stock
 * @property int $supplier_id
 *
 * @property Supplier $supplier
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%products}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['price'], 'number'],
            [['stock', 'supplier_id'], 'required'],
            [['stock', 'supplier_id'], 'integer'],
            [['supplier_id'], 'exist', 'skipOnError' => true, 'targetClass' => Supplier::class, 'targetAttribute' => ['supplier_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'price' => 'Price',
            'stock' => 'Stock',
            'supplier_id' => 'Supplier ID',
        ];
    }

    /**
     * Gets query for [[Supplier]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSupplier()
    {
        return $this->hasOne(Supplier::class, ['id' => 'supplier_id']);
    }
}
