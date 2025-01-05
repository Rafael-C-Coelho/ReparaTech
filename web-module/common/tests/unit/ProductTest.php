<?php

namespace common\tests\Unit;

use common\models\Product;
use common\models\ProductCategory;
use common\models\Sale;
use common\models\SaleProduct;
use common\models\Supplier;
use common\tests\UnitTester;
use yii\web\UploadedFile;

class ProductTest extends \Codeception\Test\Unit
{
    private const VALID_NAME = 'Test Product';
    private const VALID_PRICE = 99.99;
    private const VALID_STOCK = 10;

    protected UnitTester $tester;
    private $category;
    private $supplier;

    protected function _before()
    {
        $this->supplier = new Supplier();
        $this->supplier->name = 'Test Supplier';
        $this->supplier->save();

        $this->category = new ProductCategory();
        $this->category->name = 'Test Category';
        $this->category->save();
        Product::deleteAll();
    }

    public function testRequiredFields()
    {
        $product = new Product();
        $this->assertFalse($product->validate());

        foreach (['name', 'stock', 'supplier_id', 'category_id'] as $attribute) {
            $this->assertTrue($product->hasErrors($attribute));
        }
    }

    public function testPriceValidation()
    {
        $product = $this->createValidProduct();

        $product->price = -10;
        $this->assertFalse($product->validate(['price']));

        $product->price = 0;
        $this->assertFalse($product->validate(['price']));

        $product->price = self::VALID_PRICE;
        $this->assertTrue($product->validate(['price']));
    }

    public function testStockValidation()
    {
        $product = $this->createValidProduct();

        $product->stock = -5;
        $this->assertFalse($product->validate(['stock']));

        $product->stock = self::VALID_STOCK;
        $this->assertTrue($product->validate(['stock']));
    }

    public function testCustomStockValidation()
    {
        $product = $this->createValidProduct();

        $sale = new Sale();
        $sale->save();
        $saleProduct = new SaleProduct();
        $saleProduct->product_id = $product->id;
        $saleProduct->quantity = 5;
        $saleProduct->sale_id = $sale->id;
        $saleProduct->save();

        $product = Product::findOne($product->id);
        $product->refresh();
        $this->assertEquals(5, $product->stock);

        $product->stock = 20;
        $product->validateStockLevel('stock', []);
        $this->assertFalse($product->hasErrors('stock'));
    }

    public function testCustomPriceValidation()
    {
        $product = $this->createValidProduct();

        $product->price = 0;
        $product->validatePrice('price', []);
        $this->assertTrue($product->hasErrors('price'));

        $product->price = -1;
        $product->validatePrice('price', []);
        $this->assertTrue($product->hasErrors('price'));

        $product->price = self::VALID_PRICE;
        $product->validate(['price']);
        $product->validatePrice('price', []);
        $this->assertFalse($product->hasErrors('price'));
    }

    public function testRelationships()
    {
        $product = $this->createValidProduct();

        $this->assertNotNull($product->supplier);
        $this->assertNotNull($product->category);
        $this->assertNotNull($product->saleProducts);
    }

    public function testForeignKeyValidation()
    {
        $product = $this->createValidProduct();

        $product->supplier_id = 999999;
        $this->assertFalse($product->validate(['supplier_id']));

        $product->category_id = 999999;
        $this->assertFalse($product->validate(['category_id']));
    }

    private function createValidProduct()
    {
        $product = new Product();
        $product->name = self::VALID_NAME;
        $product->price = self::VALID_PRICE;
        $product->stock = self::VALID_STOCK;
        $product->supplier_id = $this->supplier->id;
        $product->category_id = $this->category->id;
        $product->save();
        return $product;
    }
}