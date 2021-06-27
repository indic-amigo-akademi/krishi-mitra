<?php

use App\FileImage;
use App\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function __construct()
    {
        $this->faker = Faker\Factory::create();
        $this->faker->seed(1234);
    }

    public function get_redirect_uri($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $a = curl_exec($ch);
        $uri = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
        curl_close($ch);
        return $uri;
    }

    public function download_url($url)
    {
        $redirect_uri = $this->get_redirect_uri($url);
        $basename = basename(parse_url($redirect_uri, PHP_URL_PATH));
        $destinationPath = public_path(
            'uploads' . DIRECTORY_SEPARATOR . 'products'
        );
        $filename = pathinfo($basename, PATHINFO_FILENAME);
        $extension = pathinfo($basename, PATHINFO_EXTENSION);
        $imageName = $filename . time() . '.' . $extension;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $redirect_uri);

        $fp = fopen($destinationPath . DIRECTORY_SEPARATOR . $imageName, 'w');

        curl_setopt($ch, CURLOPT_FILE, $fp);

        curl_exec($ch);
        curl_close($ch);
        fclose($fp);

        return $imageName;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $product1 = Product::create([
            'type' => 'Vegetables',
            'seller_id' => 1,
            'desc' => '<p>This is a potato</p>',
            'price' => 15,
            'name' => 'Aloo Jyoti',
            'unit' => 'KGS',
            'quantity' => '133',
            'slug' => 'aloo_jyoti',
            'discount' => 0.3,
        ]);
        $image1_1 = $this->download_url(
            'https://cdn.britannica.com/w:1100/89/170689-131-D20F8F0A/Potatoes.jpg'
        );
        FileImage::create([
            'name' => $image1_1,
            'type' => 'products',
            'ref_id' => $product1->id,
        ]);

        $image2_1 = $this->download_url(
            'https://cisock.files.wordpress.com/2019/06/potato-1.jpg'
        );
        FileImage::create([
            'name' => $image2_1,
            'type' => 'products',
            'ref_id' => $product1->id,
        ]);

        $product2 = Product::create([
            'type' => 'Vegetables',
            'seller_id' => 3,
            'desc' => '<p>This is an onion</p>',
            'price' => 25,
            'name' => 'Onion',
            'unit' => 'KGS',
            'quantity' => '133',
            'slug' => 'onion',
            'discount' => 0.4,
        ]);
        $image1_2 = $this->download_url(
            'https://mastomart.in/wp-content/uploads/2020/08/Red-Onion.jpg'
        );
        FileImage::create([
            'name' => $image1_2,
            'type' => 'products',
            'ref_id' => $product2->id,
        ]);

        $image2_2 = $this->download_url(
            'https://www.foodqualityandsafety.com/wp-content/uploads/2018/08/FQU_eUpdate_0925_onions.jpg'
        );
        FileImage::create([
            'name' => $image2_2,
            'type' => 'products',
            'ref_id' => $product2->id,
        ]);

        $product3 = Product::create([
            'type' => 'Vegetables',
            'seller_id' => 3,
            'desc' => '<p>This is a carrot</p>',
            'price' => 10,
            'name' => 'Carrot',
            'unit' => 'KGS',
            'quantity' => '133',
            'slug' => 'carrot',
            'discount' => 0.4,
        ]);

        $image1_3 = $this->download_url(
            'https://i.ndtvimg.com/mt/cooks/2014-11/carrots.jpg'
        );
        FileImage::create([
            'name' => $image1_3,
            'type' => 'products',
            'ref_id' => $product3->id,
        ]);

        $product4 = Product::create([
            'type' => 'Vegetables',
            'seller_id' => 3,
            'desc' => '<p>This is a cauliflower</p>',
            'price' => 20,
            'name' => 'Cauliflower',
            'unit' => 'KGS',
            'quantity' => '133',
            'slug' => 'cauliflower',
            'discount' => 0.4,
        ]);

        $image1_4 = $this->download_url(
            'https://www.organicfacts.net/wp-content/uploads/cauliflower-1.jpg'
        );
        FileImage::create([
            'name' => $image1_4,
            'type' => 'products',
            'ref_id' => $product4->id,
        ]);

        $product5 = Product::create([
            'type' => 'Vegetables',
            'seller_id' => 2,
            'desc' => '<p>This is a brinjal</p>',
            'price' => 20,
            'name' => 'Brinjal',
            'unit' => 'KGS',
            'quantity' => '133',
            'slug' => 'brinjal',
            'discount' => 0.4,
        ]);

        $image1_5 = $this->download_url(
            'https://www.astrogle.com/images/2015/01/brinjal.jpg'
        );
        FileImage::create([
            'name' => $image1_5,
            'type' => 'products',
            'ref_id' => $product5->id,
        ]);

        $product6 = Product::create([
            'type' => 'Fruits',
            'seller_id' => 2,
            'desc' => '<p>This is an apple</p>',
            'price' => 20,
            'name' => 'Apple',
            'unit' => 'KGS',
            'quantity' => '133',
            'slug' => 'apple',
            'discount' => 0.4,
        ]);

        $image1_6 = $this->download_url(
            'https://gropick.in/wp-content/uploads/2019/03/Red-Apple-600x400.jpg'
        );
        FileImage::create([
            'name' => $image1_6,
            'type' => 'products',
            'ref_id' => $product6->id,
        ]);

        $product7 = Product::create([
            'type' => 'Fruits',
            'seller_id' => 1,
            'desc' => '<p>This is a mango</p>',
            'price' => 20,
            'name' => 'Mango',
            'unit' => 'KGS',
            'quantity' => '133',
            'slug' => 'mango',
            'discount' => 0.4,
        ]);

        $image1_7 = $this->download_url(
            'https://plantogram.com/wa-data/public/shop/products/55/06/655/images/1256/1256.750@2x.jpg'
        );
        FileImage::create([
            'name' => $image1_7,
            'type' => 'products',
            'ref_id' => $product7->id,
        ]);

        $product8 = Product::create([
            'type' => 'Cereals',
            'seller_id' => 2,
            'desc' => '<p>This is wheat</p>',
            'price' => 20,
            'name' => 'Wheat',
            'unit' => 'KGS',
            'quantity' => '133',
            'slug' => 'wheat',
            'discount' => 0.4,
        ]);

        $image1_8 = $this->download_url(
            'http://sc04.alicdn.com/kf/U7dd3de68437c4675a6fd7b2c9ebd6251u.png'
        );
        FileImage::create([
            'name' => $image1_8,
            'type' => 'products',
            'ref_id' => $product8->id,
        ]);

        $product9 = Product::create([
            'type' => 'Cereals',
            'seller_id' => 2,
            'desc' => '<p>This is moong pulse</p>',
            'price' => 20,
            'name' => 'Moong_pulse',
            'unit' => 'KGS',
            'quantity' => '133',
            'slug' => 'moong_pulse',
            'discount' => 0.4,
        ]);

        $image1_9 = $this->download_url(
            'https://5.imimg.com/data5/GB/VC/MY-17000375/moong-dhuli-500x500.jpg'
        );
        FileImage::create([
            'name' => $image1_9,
            'type' => 'products',
            'ref_id' => $product9->id,
        ]);

        $product10 = Product::create([
            'type' => 'Fruits',
            'seller_id' => 2,
            'desc' => '<p>This is lemon</p>',
            'price' => 20,
            'name' => 'Lemon',
            'unit' => 'KGS',
            'quantity' => '133',
            'slug' => 'lemon',
            'discount' => 0.4,
        ]);

        $image1_10 = $this->download_url(
            'https://i.ndtvimg.com/mt/cooks/2014-11/lemon.jpg'
        );
        FileImage::create([
            'name' => $image1_10,
            'type' => 'products',
            'ref_id' => $product10->id,
        ]);

        $product11 = Product::create([
            'type' => 'Fruits',
            'seller_id' => 3,
            'desc' => '<p>This is sapota</p>',
            'price' => 20,
            'name' => 'Sapota',
            'unit' => 'KGS',
            'quantity' => '133',
            'slug' => 'sapota',
            'discount' => 0.4,
        ]);

        $image1_11 = $this->download_url(
            'https://5.imimg.com/data5/SELLER/Default/2020/9/VN/EA/YC/13355905/naseberry-sapota-500x500.jpg'
        );
        FileImage::create([
            'name' => $image1_11,
            'type' => 'products',
            'ref_id' => $product11->id,
        ]);

        $product12 = Product::create([
            'type' => 'Fruits',
            'seller_id' => 2,
            'desc' => '<p>This is guava</p>',
            'price' => 20,
            'name' => 'Guava',
            'unit' => 'KGS',
            'quantity' => '133',
            'slug' => 'guava',
            'discount' => 0.4,
        ]);

        $image1_12 = $this->download_url(
            'https://greenhands.bt/uploads/images/product/1609837771-Uo3JYTys.jpeg'
        );
        FileImage::create([
            'name' => $image1_12,
            'type' => 'products',
            'ref_id' => $product12->id,
        ]);

        for ($i = 0; $i < 50; $i++) {
            $product_name = $this->faker->bothify('Product**##');
            $product = Product::create([
                'type' =>
                    Product::$categories[array_rand(Product::$categories)],
                'seller_id' => random_int(1, 3),
                'desc' => sprintf('<p>%s</p>', $this->faker->paragraph(3)),
                'price' => random_int(5, 50),
                'name' => $product_name,
                'unit' => array_rand(Product::$units),
                'quantity' => random_int(50, 500),
                'slug' => Str::slug($product_name),
                'discount' => $this->faker->randomFloat(2, 0, 1),
            ]);

            $image = $this->download_url('https://picsum.photos/250');
            FileImage::create([
                'name' => $image,
                'type' => 'products',
                'ref_id' => $product->id,
            ]);
        }
    }
}
