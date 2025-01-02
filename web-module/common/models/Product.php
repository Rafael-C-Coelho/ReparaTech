<?php

namespace common\models;

/**
 * This is the model class for table "{{%products}}".
 *
 * @property int $id
 * @property float|null $price
 * @property int $stock
 * @property int $supplier_id
 * @property int $category_id
 *
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
            // Required fields
            [['name', 'stock', 'supplier_id', 'category_id'], 'required'],

            // Data type validation
            [['price'], 'number', 'min' => 0, 'message' => 'Price cannot be negative'],
            [['stock'], 'integer', 'min' => 0, 'message' => 'Stock cannot be negative'],
            [['supplier_id', 'category_id'], 'integer'],
            [['name'], 'string', 'max' => 255],

            // Foreign key constraints
            [['supplier_id'], 'exist',
                'skipOnError' => true,
                'targetClass' => Supplier::class,
                'targetAttribute' => ['supplier_id' => 'id'],
                'message' => 'Selected supplier does not exist'
            ],
            [['category_id'], 'exist',
                'skipOnError' => true,
                'targetClass' => ProductCategory::class,
                'targetAttribute' => ['category_id' => 'id'],
                'message' => 'Selected category does not exist'
            ],

            // Image validation
            [['image'], 'file',
                'extensions' => 'png, jpg, jpeg',
                'maxSize' => 1024 * 1024 * 8,
                'mimeTypes' => ['image/jpeg', 'image/png'],
                'wrongMimeType' => 'Only JPG and PNG files are allowed.',
                'tooBig' => 'File size must not exceed 8MB'
            ],

            // Custom validations
            ['stock', 'validateStockLevel'],
            ['price', 'validatePrice'],

            // Safe attributes
            [['description'], 'safe']
        ];
    }

    public function validateStockLevel($attribute, $params)
    {
        if ($this->stock < 0) {
            $this->addError($attribute, 'Stock level cannot be negative');
            return;
        }

        $pendingOrders = SaleProduct::find()
            ->where(['product_id' => $this->id])
            ->sum('quantity') ?? 0;

        if ($this->stock < $pendingOrders) {
            $this->addError($attribute, 'Stock cannot be less than pending orders');
        }
    }

    public function validatePrice($attribute, $params)
    {
        if ($this->price !== null && $this->price <= 0) {
            $this->addError($attribute, 'Price must be greater than zero');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'price' => 'Price',
            'stock' => 'Stock',
            'supplier_id' => 'Supplier',
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

    public function getCategory()
    {
        return $this->hasOne(ProductCategory::class, ['id' => 'category_id']);
    }

    public function getSaleProducts()
    {
        return $this->hasMany(SaleProduct::class, ['product_id' => 'id']);
    }
}
