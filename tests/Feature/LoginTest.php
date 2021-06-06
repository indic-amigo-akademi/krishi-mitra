<?php

namespace Tests\Feature;
use App\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    
    public function testlogin(){

        //Create user
        $data=[
        'name' => 'Test',
        'username' => 'Test123',
        'phonenumber'=>'1234567890',
        'email'=>'test@gmail.com',
        'password' => 'secret1234',
        'password_confirmation' => 'secret1234',
    ];
    //attempt login
    $response = $this->json('POST',route('user.login.validate'),[
        'email' => 'test@gmail.com',
        'password' => 'secret1234',
    ]);
    $response->assertStatus(200);
    }
    
    
    

}
