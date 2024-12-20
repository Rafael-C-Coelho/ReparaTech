<?php

namespace common\models;

use common\models\Products;
use common\models\Sales;

/**
 * This is the model class for table "{{%sales_has_products}}".
 *
 * @property int $id
 * @property int $sale_id
 * @property int $product_id
 * @property int $quantity
 * @property float $total_price
 *
 * @property Product $product
 * @property Sale $sale
 */
class SaleProduct extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sales_has_products}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sale_id', 'product_id', 'quantity', 'total_price'], 'required'],
            [['sale_id', 'product_id', 'quantity'], 'integer'],
            [['total_price'], 'number'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
            [['sale_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sale::class, 'targetAttribute' => ['sale_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sale_id' => 'Sale ID',
            'product_id' => 'Product ID',
            'quantity' => 'Quantity',
            'total_price' => 'Total Price',
        ];
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    /**
     * Gets query for [[Sale]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSale()
    {
        return $this->hasOne(Sale::class, ['id' => 'sale_id']);
    }
}
