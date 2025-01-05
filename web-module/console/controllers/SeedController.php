<?php
namespace console\controllers;

use common\models\Product;
use common\models\ProductCategory;
use common\models\Supplier;
use Faker\Factory;
use yii\console\Controller;
use common\models\User;

class SeedController extends Controller
{
    public function actionInit()
    {
        // Category seeding
        $this->seedCategories();
        echo "Categories seeded successfully!\n";
        $this->seedProducts();
        echo "Products seeded successfully!\n";
        echo "Seeding completed successfully!\n";
    }

    protected function seedCategories()
    {
        $categories = ['Laptops', 'Desktops', 'Mobile Phones', 'Tablets', 'Accessories', 'Software', 'Printers', 'Monitors', 'Networking', 'Storage', 'Servers', 'Others'];
        $faker = Factory::create();

        $supplier = new Supplier([
            'name' => 'At Tech Supplier',
            'contact' => $faker->phoneNumber,
        ]);
        $supplier->save();

        foreach ($categories as $categoryName) {
            $category = new ProductCategory();
            $category->name = $categoryName;
            $category->save();

            $product = new Product([
                'name' => $faker->name,
                'category_id' => $category->id,
                'supplier_id' => $supplier->id,
                'price' => $faker->randomFloat(2, 10, 500),
                'stock' => $faker->numberBetween(0, 1000),
                'image' => $faker->imageUrl(640, 480, 'tech', true),
            ]);
            $product->save();
        }
    }

    protected function seedProducts() {
        $faker = Factory::create();

        $supplier = new Supplier([
            'name' => 'Tech Supplier',
            'contact' => $faker->phoneNumber,
        ]);
        $supplier->save();

        $category = new ProductCategory([
            'name' => 'Seeded Tech',
        ]);
        $category->save();

        for ($i = 0; $i < 100; $i++) {
            $product = new Product([
                'name' => $faker->name,
                'category_id' => $category->id,
                'supplier_id' => $supplier->id,
                'price' => $faker->randomFloat(2, 10, 500),
                'stock' => $faker->numberBetween(0, 1000),
                'image' => $faker->imageUrl(640, 480, 'tech', true),
            ]);
            $product->save();
        }
    }
}