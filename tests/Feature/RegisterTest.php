<?php

namespace Tests\Feature;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    public function test_can_register()
    {
        
        $payload = [
            'name' => 'srija',
            'email' => 'karmakarsrija@gmail',
            'password' => 'srija@wp.pl',
            'password_confirmation' => 'srija@wp.pl',
        ];

        $this->json('post', '/register', $payload)
            ->assertStatus(422);      
        

    }   


    public function test_cannot_register()
    {
        
        $payload = [
            'name' => 'srija',
            'email' => 'karmakarsrija@gmail',
            'password' => 'srija@wp.pl',
            'password_confirmation' => 'abc@wp.pl',  //password does not match
        ];

        $this->json('post', '/register', $payload)
            ->assertStatus(422);      
        

    }   
    }
