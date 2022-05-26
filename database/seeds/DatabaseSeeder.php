<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function delete_directory($path)
    {
        $path = public_path($path);
        if (!is_dir($path)) {
            return;
        }
        if (substr($path, strlen($path) - 1, 1) != DIRECTORY_SEPARATOR) {
            $path .= DIRECTORY_SEPARATOR;
        }
        $files = glob($path . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                $this->delete_directory($file);
            } else {
                unlink($file);
            }
        }
        rmdir($path);
        print $path . ' is successfully deleted.' . PHP_EOL;
    }

    public function create_directory($path)
    {
        $str = explode(DIRECTORY_SEPARATOR, $path);
        $dir = '';
        foreach ($str as $part) {
            $dir .= DIRECTORY_SEPARATOR . $part;
            $abs_dir = public_path($dir);
            if (
                !is_dir($abs_dir) &&
                strlen($abs_dir) > 0 &&
                strpos($abs_dir, '.') == false
            ) {
                mkdir($abs_dir, 0777);
            } elseif (
                !file_exists($abs_dir) &&
                strpos($abs_dir, '.') !== false
            ) {
                touch($abs_dir);
            }
        }
        print $path . ' is successfully created.' . PHP_EOL;
    }

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->delete_directory('uploads' . DIRECTORY_SEPARATOR . 'products');
        $this->create_directory('uploads' . DIRECTORY_SEPARATOR . 'products');
        $this->call(UserSeeder::class);
        $this->call(SellerSeeder::class);
        $this->call(ProductSeeder::class);
    }
}
