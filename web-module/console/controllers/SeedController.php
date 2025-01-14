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
    private $categories;

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
        $categories = ['Laptops', 'Desktops', 'Mobile Phones', 'Tablets'];
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

            $this->categories[] = $category;
        }
    }

    protected function seedProducts() {
        $laptops_product_images = [
            "category_id" => 0,
            "urls" => [
                "https://gfx3.senetic.com/akeneo-catalog/f/6/e/6/f6e64a862fe63da6a23c2f90d2e0ed5f3f3a1775_1626671_5V8_00009_image1.jpg",
                "",
                "",
                "",
                "https://in-files.apjonlinecdn.com/landingpages/content-pages/visid-rich-content/hp-laptop-15s/images/desktop_laptop.png",
                "https://gfx3.senetic.com/akeneo-catalog/f/c/a/a/fcaa2a04ea8915724ba1f4617c44adebbccadc3f_1626665_7IC_00009_image1.jpg",
                "https://digiplanet.pt/cdn/shop/files/840G6i7_5.png?v=1729596646",
                "https://techterms.com/img/xl/laptop_586.png",
                "https://www.asus.com/media/Odin/Websites/global/Series/9.png",
                "",
                "https://images-cdn.ubuy.co.in/64c41e4771c5f52216163af1-hp-stream-14-laptop-intel-celeron.jpg",
            ]
        ];
        $desktops_product_images = [
            "category_id" => 1,
            "urls" => [
                "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQSCl9h3BZb6-Erb20O_m0xf44GMZe88cGKyQ&s",
                "https://dell.itpoint.pt/cdn/shop/collections/14df054734d2391be8ed7eb6fc7264d3.jpg?v=1672755936",
                "https://www.dellstore.com/pub/media/catalog/category/optiplex-13-5-category.png",
                "https://i.ebayimg.com/thumbs/images/g/MbUAAOSwI7ZimiI5/s-l1200.jpg",
                "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRVrHIdo16AfJMG2gF5wOvgYqQ1gqa1s-yfjw&s",
                "https://www.omen.com/content/dam/sites/omen/worldwide/desktops/2022-desktop-home-2-0/35L_Intel.png",
                "https://media.johnlewiscontent.com/i/JohnLewis/desktops_hyb3_140823?fmt=auto",
                "https://intelcorp.scene7.com/is/image/intelcorp/all-in-one-product-image-transparent-background:1920-1080?wid=576&hei=324&fmt=webp-alpha",
                "https://mms.businesswire.com/media/20240416932396/pt/2099277/5/Picture1.jpg",
                "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQEbCRWymfyE40EaL6cPRpkj3XFf1r0GzEemQ&s",
                "https://www.atlasce.ca/cdn/shop/collections/HP-800-G2-Intel-i7-8GB-500GB-HDD-Windows-10-Pro-WiFi-Desktop-PC.webp?v=1716562339",
            ]
        ];
        $phones_product_images = [
            "category_id" => 2,
            "urls" => [
                "https://assets.swappie.com/cdn-cgi/image/width=600,height=600,fit=contain,format=auto/swappie-iphone-13-pro-sierra-blue-back.png?v=63198538",
                "https://www.gms-store.com/products/iphone-16-pro-mynf3ql-a",
                "https://lirp.cdn-website.com/8ac3ee00/dms3rep/multi/opt/durasport5g-front-all-phones-640w.png",
                "https://www.amazon.co.uk/Mobile-Smartphone-Android-Recognition-Unlocked-blue/dp/B09SL86YD4",
                "https://www.kuantokusta.pt/p/8567456/nothing-phone-1-655-dual-sim-8gb256gb-black",
                "https://lh3.googleusercontent.com/yNVCCLko19YvTDwqxtNIYVkDtg_k8wzwHgNlft1ktbVwjDTgk0mrCSmbglSsak4TUyD9jNcVkx4S7ICHZE4wFwd5kbMC8H_BynxL",
                "https://www.philips.ng/c-m-so/mobile-tablets/mobile-phones/latest",
                "https://nothing.tech/cdn/shop/files/2048x1352BuyPage-BlackPhone-1.png?v=1720093601",
                "https://media.npr.org/assets/img/2017/02/15/gettyimages-90739545_wide-5d8ae4cd5a2949f1f60c04f0c60a8f8e88eee3f5.jpg?s=1100&c=85&f=jpeg",
                "https://www.sightandsound.co.uk/product/minivision2-mobile-phone/",
                "https://media.kasperskydaily.com/wp-content/uploads/sites/92/2021/10/15063756/dangerous-feature-phones-featured.jpg",
            ]
        ];
        $tablets_product_images = [
            "category_id" => 3,
            "urls" => [
                "https://p2-ofp.static.pub/fes/cms/2023/02/22/pkhjbh23c7sjfxf76k6e6usevy3ixi851221.png",
                "https://cdn.thewirecutter.com/wp-content/media/2024/06/besttablets-2048px-9875.jpg",
                "https://images-cdn.ubuy.qa/633b51122af1ce605a57ae50-10-1.jpg",
                "https://lojae-s3-prd-files.radiopopular.pt/files/static/images/products/99244_0.jpg",
                "https://aws-obg-image-lb-1.tcl.com/content/dam/brandsite/region/global/products/tablets/tcl-nxtpaper-14/id/1.png?t=1721272443153&w=800&webp=true&dpr=2.625&rendition=1068",
                "https://img01.huaweifile.com/eu/pt/huawei/pms/uomcdn/PTHW/pms/202405/gbom/6942103126079/428_428_9086DA17F2EB0FC79CDE47B602967ED1mp.png",
                "https://www.powerplanetonline.com/cdnassets/lenovo_tab_m10_3rd_gen_gris_01_m.jpg",
                "https://consumer.huawei.com/content/dam/huawei-cbg-site/common/mkt/plp-x/tablet/autumn-2024-wearable-launch/matepad-series/huawei-matepad-11-5-s.jpg",
                "https://static.fnac-static.com/multimedia/Images/PT/NR/41/54/86/8803393/1540-1.jpg",
                "https://www.worten.pt/i/08198dc8a9df502d0898fb16cf1e8f927e230a42",
                "https://conteudos.meo.pt/catalogo/isell/equipamentos_moveis/lenovo/lenovo-tab-m11-tb330-wifi/lenovo-tab-m11-tb330-wifi-cinza-perfil-capa-pen-meo.png",
            ]
        ];

        $data = [
            $laptops_product_images,
            $desktops_product_images,
            $phones_product_images,
            $tablets_product_images,
        ];

        $faker = Factory::create();

        $supplier = new Supplier([
            'name' => 'Tech Supplier',
            'contact' => $faker->phoneNumber,
        ]);
        $supplier->save();

        foreach ($data as $product_images) {
            foreach ($product_images['urls'] as $url) {
                $category = $this->categories[$product_images['category_id']];
                $product = new Product([
                    'name' => $faker->words(2, true),
                    'category_id' => $category->id,
                    'supplier_id' => $supplier->id,
                    'price' => $faker->randomFloat(2, 10, 500),
                    'stock' => $faker->numberBetween(0, 1000),
                    'image' => $url,
                ]);
                $product->save();
            }
        }
    }
}