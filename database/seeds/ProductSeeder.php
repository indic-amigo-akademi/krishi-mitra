<?php

use App\FileImage;
use App\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{

    public function download_image($url)
    {
        $contents = file_get_contents($url);
        $basename = basename($url);
        $destinationPath = public_path('uploads'.DIRECTORY_SEPARATOR.'products');
        $filename = pathinfo(
            $basename,
            PATHINFO_FILENAME
        );
        $extension = pathinfo(
            $basename,
            PATHINFO_EXTENSION
        );
        $imageName = $filename . time() . '.' . $extension;
        file_put_contents($destinationPath . DIRECTORY_SEPARATOR . $imageName, $contents);
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
            'type' => 'Vegetable',
            'seller_id' => 1,
            'desc' => "<p>This is a potato<p>",
            'price' => 15,
            'name' => 'Aloo Jyoti',
            'unit' => 'KGS',
            'quantity' => '133',
            'slug' => 'aloo_jyoti',
            'discount' => 0.3,
        ]);
        $image1_1 = $this->download_image("https://cdn.britannica.com/w:1100/89/170689-131-D20F8F0A/Potatoes.jpg");
        FileImage::create([
            'name' => $image1_1, 'type' => 'products', 'ref_id' => $product1->id
        ]);

        $image2_1 = $this->download_image("https://cisock.files.wordpress.com/2019/06/potato-1.jpg");
        FileImage::create([
            'name' => $image2_1, 'type' => 'products', 'ref_id' => $product1->id
        ]);

        $product2 = Product::create([
            'type' => 'Vegetable',
            'seller_id' => 3,
            'desc' => "<p>This is an onion<p>",
            'price' => 25,
            'name' => 'Onion',
            'unit' => 'KGS',
            'quantity' => '133',
            'slug' => 'onion',
            'discount' => 0.4,
        ]);
        $image1_2 = $this->download_image("https://mastomart.in/wp-content/uploads/2020/08/Red-Onion.jpg");
        FileImage::create([
            'name' => $image1_2, 'type' => 'products', 'ref_id' => $product2->id
        ]);

        $image2_2 = $this->download_image("https://www.foodqualityandsafety.com/wp-content/uploads/2018/08/FQU_eUpdate_0925_onions.jpg");
        FileImage::create([
            'name' => $image2_2, 'type' => 'products', 'ref_id' => $product2->id
        ]);

        $product3 = Product::create([
            'type' => 'Vegetable',
            'seller_id' => 3,
            'desc' => "<p>This is a carrot<p>",
            'price' => 10,
            'name' => 'Carrot',
            'unit' => 'KGS',
            'quantity' => '133',
            'slug' => 'carrot',
            'discount' => 0.4,
        ]);

        $image1_3 = $this->download_image("https://i.ndtvimg.com/mt/cooks/2014-11/carrots.jpg");
        FileImage::create([
            'name' => $image1_3, 'type' => 'products', 'ref_id' => $product3->id
        ]);

        $product4 = Product::create([
            'type' => 'Vegetable',
            'seller_id' => 3,
            'desc' => "<p>This is a cauliflower<p>",
            'price' => 20,
            'name' => 'Cauliflower',
            'unit' => 'KGS',
            'quantity' => '133',
            'slug' => 'cauliflower',
            'discount' => 0.4,
        ]);

        $image1_4 = $this->download_image("https://www.organicfacts.net/wp-content/uploads/cauliflower-1.jpg");
        FileImage::create([
            'name' => $image1_4, 'type' => 'products', 'ref_id' => $product4->id
        ]);

        $product5 = Product::create([
            'type' => 'Vegetable',
            'seller_id' => 2,
            'desc' => "<p>This is a brinjal<p>",
            'price' => 20,
            'name' => 'Brinjal',
            'unit' => 'KGS',
            'quantity' => '133',
            'slug' => 'brinjal',
            'discount' => 0.4,
        ]);

        $image1_5 = $this->download_image("https://www.astrogle.com/images/2015/01/brinjal.jpg");
        FileImage::create([
            'name' => $image1_5, 'type' => 'products', 'ref_id' => $product5->id
        ]);

        $product6 = Product::create([
            'type' => 'Fruit',
            'seller_id' => 2,
            'desc' => "<p>This is an apple<p>",
            'price' => 20,
            'name' => 'Apple',
            'unit' => 'KGS',
            'quantity' => '133',
            'slug' => 'apple',
            'discount' => 0.4,
        ]);

        $image1_6 = $this->download_image("https://gropick.in/wp-content/uploads/2019/03/Red-Apple-600x400.jpg");
        FileImage::create([
            'name' => $image1_6, 'type' => 'products', 'ref_id' => $product6->id
        ]);

        $product7 = Product::create([
            'type' => 'Fruit',
            'seller_id' => 1,
            'desc' => "<p>This is a mango<p>",
            'price' => 20,
            'name' => 'Mango',
            'unit' => 'KGS',
            'quantity' => '133',
            'slug' => 'mango',
            'discount' => 0.4,
        ]);

        $image1_7 = $this->download_image("https://plantogram.com/wa-data/public/shop/products/55/06/655/images/1256/1256.750@2x.jpg");
        FileImage::create([
            'name' => $image1_7, 'type' => 'products', 'ref_id' => $product7->id
        ]);


        $product8 = Product::create([
            'type' => 'Crop',
            'seller_id' => 2,
            'desc' => "<p>This is wheat<p>",
            'price' => 20,
            'name' => 'Wheat',
            'unit' => 'KGS',
            'quantity' => '133',
            'slug' => 'wheat',
            'discount' => 0.4,
        ]);

        $image1_8 = $this->download_image("http://sc04.alicdn.com/kf/U7dd3de68437c4675a6fd7b2c9ebd6251u.png");
        FileImage::create([
            'name' => $image1_8, 'type' => 'products', 'ref_id' => $product8->id
        ]);


        $product9 = Product::create([
            'type' => 'Crop',
            'seller_id' => 2,
            'desc' => "<p>This is moong pulse<p>",
            'price' => 20,
            'name' => 'Moong_pulse',
            'unit' => 'KGS',
            'quantity' => '133',
            'slug' => 'moong_pulse',
            'discount' => 0.4,
        ]);

        $image1_9 = $this->download_image("https://5.imimg.com/data5/GB/VC/MY-17000375/moong-dhuli-500x500.jpg");
        FileImage::create([
            'name' => $image1_9, 'type' => 'products', 'ref_id' => $product9->id
        ]);


        $product10 = Product::create([
            'type' => 'Fruit',
            'seller_id' => 2,
            'desc' => "<p>This is lemon<p>",
            'price' => 20,
            'name' => 'Lemon',
            'unit' => 'KGS',
            'quantity' => '133',
            'slug' => 'lemon',
            'discount' => 0.4,
        ]);

        $image1_10 = $this->download_image("https://i.ndtvimg.com/mt/cooks/2014-11/lemon.jpg");
        FileImage::create([
            'name' => $image1_10, 'type' => 'products', 'ref_id' => $product10->id
        ]);


        $product11 = Product::create([
            'type' => 'Fruit',
            'seller_id' => 3,
            'desc' => "<p>This is sapota<p>",
            'price' => 20,
            'name' => 'Sapota',
            'unit' => 'KGS',
            'quantity' => '133',
            'slug' => 'sapota',
            'discount' => 0.4,
        ]);

        $image1_11 = $this->download_image("https://www.yeseshop.in/image/cache/catalog/Fruits%20N%20Veg/Sapota%20Cheekoo-550x550.jpg");
        FileImage::create([
            'name' => $image1_11, 'type' => 'products', 'ref_id' => $product11->id
        ]);

        $product12 = Product::create([
            'type' => 'Fruit',
            'seller_id' => 2,
            'desc' => "<p>This is guava<p>",
            'price' => 20,
            'name' => 'Guava',
            'unit' => 'KGS',
            'quantity' => '133',
            'slug' => 'guava',
            'discount' => 0.4,
        ]);

        $image1_12 = $this->download_image("https://greenhands.bt/uploads/images/product/1609837771-Uo3JYTys.jpeg");
        FileImage::create([
            'name' => $image1_12, 'type' => 'products', 'ref_id' => $product12->id
        ]);
    }
}
