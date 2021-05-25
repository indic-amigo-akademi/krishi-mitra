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
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }


    public function test_can_login()
    {
        
        $payload = [
            
            'email' => 'karmakarsrija@gmail',
            'password' => 'srija@wp.pl',
           
        ];

        $this->json('post', '/login', $payload)
            ->assertStatus(302);      
        

    }   

    
    

}
