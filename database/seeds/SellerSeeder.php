<?php

use App\Seller;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SellerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1 = User::create([
            'name' => 'Krishi Vikas',
            'username' => 'kviskas',
            'email' => 'krishi.vikas@krishimitra.com',
            'phone' => '9123801180',
            'password' => Hash::make('6Qzigg1suitA'),
            'role' => 'seller',
        ]);
        Seller::create([
            'user_id' => $user1->id,
        ]);
        User::create([
            'name' => 'Kishan Manohar',
            'username' => 'kmanohar',
            'email' => 'kishan.manohar@krishimitra.com',
            'phone' => '9123801180',
            'password' => Hash::make('tSkUm2rB499L'),
            'role' => 'seller',
        ]);
        Seller::create([]);
        User::create([
            'name' => 'Vilati Damodar',
            'username' => 'vdamodar',
            'email' => 'vilati.damodar@krishimitra.com',
            'phone' => '9123801180',
            'password' => Hash::make('8DmG9rP8h43P'),
            'role' => 'seller',
        ]);
    }
}
