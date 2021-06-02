<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function delete_directory($path)
    {
        if (!is_dir($path)) {
            return;
        }
        if (substr($path, strlen($path) - 1, 1) != '/') {
            $path .= '/';
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
        print($path . " is successfully deleted." . PHP_EOL);
    }

    public function create_directory($path)
    {
        $str = explode(DIRECTORY_SEPARATOR, $path);
        $dir = '';
        foreach ($str as $part) {
            $dir .= DIRECTORY_SEPARATOR . $part;
            if (!is_dir($dir) && strlen($dir) > 0 && strpos($dir, ".") == false) {
                mkdir($dir, 0777);
            } elseif (!file_exists($dir) && strpos($dir, ".") !== false) {
                touch($dir);
            }
        }
        print($path . " is successfully created." . PHP_EOL);
    }

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->delete_directory(public_path('uploads/products'));
        $this->create_directory(public_path('uploads/products'));
        $this->call(UserSeeder::class);
        $this->call(SellerSeeder::class);
        $this->call(ProductSeeder::class);
    }
}
