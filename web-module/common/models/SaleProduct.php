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

    public function fields()
    {
        $fields = parent::fields();
        unset($fields['product_id']); // Optionally hide repairman_id if you don't want it to appear
        $fields['product'] = function () {
            if ($this->product === null) {
                return null;
            }
            return $this->product;
        };
        return $fields;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // Required fields
            [['sale_id', 'product_id', 'quantity', 'total_price'], 'required'],

            // Data type validation
            [['sale_id', 'product_id', 'quantity'], 'integer'],
            [['total_price'], 'number'],

            // Foreign key constraints
            [['product_id'], 'exist',
                'skipOnError' => true,
                'targetClass' => Product::class,
                'targetAttribute' => ['product_id' => 'id']
            ],
            [['sale_id'], 'exist',
                'skipOnError' => true,
                'targetClass' => Sale::class,
                'targetAttribute' => ['sale_id' => 'id']
            ],

            // Custom validations
            ['quantity', 'integer', 'min' => 1, 'message' => 'Quantity must be at least 1'],
            ['total_price', 'number', 'min' => 0, 'message' => 'Total price cannot be negative'],
            ['product_id', 'validateProductStock'],
            ['total_price', 'validateTotalPrice'],
        ];
    }

    public function validateProductStock($attribute, $params)
    {
        $product = Product::findOne($this->product_id);
        if ($product && $product->stock < $this->quantity) {
            $this->addError($attribute, 'Insufficient stock available');
        }
    }

    public function validateTotalPrice($attribute, $params)
    {
        $product = Product::findOne($this->product_id);
        if ($product) {
            $expectedTotal = $this->quantity * $product->price;
            if (abs($this->total_price - $expectedTotal) > 0.01) {
                $this->addError($attribute, 'Total price does not match quantity * product price');
            }
        }
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

    public function getSaleProducts()
    {
        return $this->hasMany(SaleProduct::className(), ['sale_id' => 'id']);
    }
}
