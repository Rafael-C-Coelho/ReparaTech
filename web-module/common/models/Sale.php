<?php

namespace common\models;

use common\models\Invoices;
use common\models\SalesHasProducts;
use common\models\User;

/**
 * This is the model class for table "{{%sales}}".
 *
 * @property int $id
 * @property int $client_id
 * @property int $invoice_id
 * @property string $address
 * @property string $zip_code
 *
 * @property User $client
 * @property Invoice $invoice
 * @property SaleProduct[] $saleProduct
 */
class Sale extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sales}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client_id'], 'required'],
            [['client_id', 'invoice_id'], 'integer'],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['client_id' => 'id']],
            [['invoice_id'], 'exist', 'skipOnError' => true, 'targetClass' => Invoice::class, 'targetAttribute' => ['invoice_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'client_id' => 'Client ID',
            'invoice_id' => 'Invoice ID',
            'address' => 'Address',
            'zip_code' => 'Zip Code',
        ];
    }

    /**
     * Gets query for [[Client]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(User::class, ['id' => 'client_id']);
    }

    /**
     * Gets query for [[Invoice]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInvoice()
    {
        return $this->hasOne(Invoice::class, ['id' => 'invoice_id']);
    }

    /**
     * Gets query for [[SalesHasProducts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSaleProduct()
    {
        return $this->hasMany(SaleProduct::class, ['sale_id' => 'id']);
    }
}
