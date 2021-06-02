<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Krishna Mitra',
            'username' => 'sysadmin',
            'email' => 'admin@krishimitra.com',
            'phone' => '9123801180',
            'password' => Hash::make('4PkgWUdAmB2bayT'),
            'role' => 'sysadmin'
        ]);
        User::create([
            'name' => 'Purbayan Chowdhury',
            'username' => 'shivishbrahma',
            'email' => 'pur.cho.99@gmail.com',
            'phone' => '9123801180',
            'password' => Hash::make('KUN8xjneJXNQQK7'),
            'role' => 'admin'
        ]);
        User::create([
            'name' => 'Shuvam Ghosal',
            'username' => 'andre',
            'email' => 'shuvamghosal98@gmail.com',
            'phone' => '8910459373',
            'password' => Hash::make('Shuvam@1998'),
            'role' => 'admin'
        ]);
        User::create([
            'name' => 'Priyadarshi Mukherjee',
            'username' => 'priyo',
            'email' => 'priyadarshi0601@gmail.com',
            'phone' => '8777046465',
            'password' => Hash::make('Priyadarshi@1999'),
            'role' => 'admin'
        ]);
        User::create([
            'name' => 'Srija Karmakar',
            'username' => 'ksrija',
            'email' => 'karmakarsrija2@gmail.com',
            'phone' => '8777046465',
            'password' => Hash::make('Srija@1998'),
            'role' => 'admin'
        ]);
        User::create([
            'name' => 'Megha Dutta',
            'username' => 'puku',
            'email' => 'meghadutta201@gmail.com',
            'phone' => '8777046465',
            'password' => Hash::make('Megha@1999'),
            'role' => 'admin'
        ]);
        User::create([
            'name' => 'Shayan Mondal',
            'username' => 'shaya',
            'email' => 'shayanmondal237@gmail.com',
            'phone' => '8777046465',
            'password' => Hash::make('Shayan@1999'),
            'role' => 'admin'
        ]);
        User::create([
            'name' => 'Mohan Dutta',
            'username' => 'mdutta',
            'email' => 'mohandutta@gmail.com',
            'phone' => '8777046465',
            'password' => Hash::make('Mohan@1999'),
            'role' => 'customer'
        ]);
    }
}
