<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function __construct()
    {
        $this->faker = Factory::create();
        $this->faker->seed(1234);
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1 = User::create([
            'name' => 'Krishna Mitra',
            'username' => 'sysadmin',
            'email' => 'admin@krishimitra.com',
            'phone' => '9123801180',
            'password' => Hash::make('4PkgWUdAmB2bayT'),
            'role' => 'sysadmin',
        ]);
        $user2 = User::create([
            'name' => 'Purbayan Chowdhury',
            'username' => 'shivishbrahma',
            'email' => 'pur.cho.99@gmail.com',
            'phone' => '9123801180',
            'password' => Hash::make('KUN8xjneJXNQQK7'),
            'role' => 'admin',
        ]);
        $user3 = User::create([
            'name' => 'Shuvam Ghosal',
            'username' => 'andre',
            'email' => 'shuvamghosal98@gmail.com',
            'phone' => '8910459373',
            'password' => Hash::make('Shuvam@1998'),
            'role' => 'admin',
        ]);
        $user4 = User::create([
            'name' => 'Priyadarshi Mukherjee',
            'username' => 'priyo',
            'email' => 'priyadarshi0601@gmail.com',
            'phone' => '8777046465',
            'password' => Hash::make('Priyadarshi@1999'),
            'role' => 'admin',
        ]);
        $user5 = User::create([
            'name' => 'Srija Karmakar',
            'username' => 'ksrija',
            'email' => 'karmakarsrija2@gmail.com',
            'phone' => '8777046465',
            'password' => Hash::make('Srija@1998'),
            'role' => 'admin',
        ]);
        $user6 = User::create([
            'name' => 'Megha Dutta',
            'username' => 'puku',
            'email' => 'meghadutta201@gmail.com',
            'phone' => '8777046465',
            'password' => Hash::make('Megha@1999'),
            'role' => 'admin',
        ]);
        $user7 = User::create([
            'name' => 'Shayan Mondal',
            'username' => 'shaya',
            'email' => 'shayanmondal237@gmail.com',
            'phone' => '8777046465',
            'password' => Hash::make('Shayan@1999'),
            'role' => 'admin',
        ]);
        $user8 = User::create([
            'name' => 'Mohan Dutta',
            'username' => 'mdutta',
            'email' => 'mohandutta@gmail.com',
            'phone' => '8777046465',
            'password' => Hash::make('Mohan@1999'),
            'role' => 'user',
        ]);
        Address::factory()->create([
            'user_id' => $user2->id,
        ]);
        Address::factory()->create([
            'user_id' => $user3->id,
        ]);
    }
}
