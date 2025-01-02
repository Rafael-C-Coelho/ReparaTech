<?php


namespace common\tests\Unit;

use Codeception\Test\Unit;
use common\models\Product;
use common\models\Supplier;
use common\models\ProductCategory;
use common\models\User;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class ProductTest extends Unit
{
    protected function _before()
    {
    }

    public function testValidProduct()
    {
        $supplier = new Supplier([
            'name' => 'Test Supplier',
            'contact' => 'Contact is 919798987'
        ]);
        $supplier->save();

        $category = new ProductCategory([
            'name' => 'Test Category'
        ]);
        $category->save();

        $product = new Product([
            'name' => 'Test Product',
            'price' => 99.99,
            'stock' => 100,
            'supplier_id' => $supplier->id,
            'category_id' => $category->id
        ]);
        verify($product->validate())->true();
    }

    public function testRequiredFields()
    {
        $product = new Product();
        verify($product->validate())->false();
        verify($product->errors)->arrayHasKey('name');
        verify($product->errors)->arrayHasKey('stock');
        verify($product->errors)->arrayHasKey('supplier_id');
        verify($product->errors)->arrayHasKey('category_id');
    }

    public function testPriceValidation()
    {
        $supplier = new Supplier([
            'name' => 'Test Supplier',
            'contact' => 'Contact is 919798987'
        ]);
        $supplier->save();

        $category = new ProductCategory([
            'name' => 'Test Category'
        ]);
        $category->save();

        $product = new Product([
            'name' => 'Test Product',
            'price' => -10,
            'stock' => 100,
            'supplier_id' => $supplier->id,
            'category_id' => $category->id
        ]);

        verify($product->validate())->false();
        verify($product->errors)->arrayHasKey('price');

        $product->price = 0;
        verify($product->validate())->false();

        $product->price = 10.99;
        verify($product->validate())->true();
    }

    public function testStockValidation()
    {
        $supplier = new Supplier([
            'name' => 'Test Supplier',
            'contact' => 'Contact is 919798987'
        ]);
        $supplier->save();

        $category = new ProductCategory([
            'name' => 'Test Category'
        ]);
        $category->save();

        $product = new Product([
            'name' => 'Test Product',
            'price' => 99.99,
            'stock' => -1,
            'supplier_id' => $supplier->id,
            'category_id' => $category->id
        ]);

        verify($product->validate())->false();
        verify($product->errors)->arrayHasKey('stock');
    }

    public function testRelationships()
    {
        $product = new Product([
            'name' => 'Test Product',
            'price' => 99.99,
            'stock' => 100,
            'supplier_id' => 999, // Non-existent supplier
            'category_id' => 999  // Non-existent category
        ]);

        verify($product->validate())->false();
        verify($product->errors)->arrayHasKey('supplier_id');
        verify($product->errors)->arrayHasKey('category_id');
    }

    public function testBeforeDelete()
    {
        $supplier = new Supplier([
            'name' => 'Test Supplier',
            'contact' => 'Contact is 919798987'
        ]);
        $supplier->save();

        $category = new ProductCategory([
            'name' => 'Test Category'
        ]);
        $category->save();
        $product = new Product([
            'name' => 'Test Product',
            'price' => 99.99,
            'stock' => 100,
            'supplier_id' => $supplier->id,
            'category_id' => $category->id
        ]);

        $client = new User();
        $client->setScenario(User::SCENARIO_CLIENT);
        $client->username = 'client1';
        $client->email = 'client@test.test';
        $client->password = 'Test@123';
        $client->setPassword('Test@123');
        $client->generateAuthKey();
        $client->name = 'Client Name';
        $client->nif = '123456789';
        $client->address = 'Test Address';
        $client->contact = '123456789';
        $client->save();

        // Create a sale for this product
        $sale = new \common\models\Sale([
            'zip_code' => '12345',
            'client_id' => $client->id,
            'address' => 'Test Address',
        ]);
        $sale->save();

        $saleProduct = new \common\models\SaleProduct([
            'product_id' => $product->id,
            'sale_id' => $sale->id,
            'quantity' => 1,
            'total_price' => $product->price
        ]);
        $saleProduct->save();

        $deleted = $product->delete() ? true : false;
        verify($deleted)->false();

        // Clean up test sale
        $saleProduct->delete();
        verify($product->delete() >= 1)->true();
    }
}
