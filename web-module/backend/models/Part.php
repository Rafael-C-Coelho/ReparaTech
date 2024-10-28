<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%parts}}".
 *
 * @property int $id
 * @property string $name
 * @property int $stock
 * @property float $price
 */
class Part extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%parts}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'stock', 'price'], 'required'],
            [['stock'], 'integer'],
            [['price'], 'number'],
            [['name'], 'string', 'max' => 255],
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
            'stock' => 'Stock',
            'price' => 'Price',
        ];
    }
}
