<?php

use App\Address;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function __construct()
    {
        $this->faker = Faker\Factory::create();
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
            'role' => 'customer',
        ]);
        $address1 = Address::create([
            'user_id' => $user2->id,
            'name' => $this->faker->name(),
            'mobile' => (int) $this->faker->regexify('[1-9]{1}[0-9]{9}'),
            'address1' => $this->faker->buildingNumber(),
            'address2' => $this->faker->streetName(),
            'city' => $this->faker->city(),
            'state' => $this->faker->state(),
            'pincode' => (int) $this->faker->postcode(),
            'landmark' => $this->faker->secondaryAddress(),
            'type' => $this->faker->randomElement(['Home', 'Work']),
        ]);
    }
}
