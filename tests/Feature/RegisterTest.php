<?php

namespace Tests\Feature;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
     public function testRegister(){
        //User's data
        $data = [
            
            'name' => 'Test',
            'username' => 'Test123',
            'phonenumber'=>'1234567890',
            'email'=>'test@123',
            'password' => 'secret1234',
            'password_confirmation' => 'secret1234',
        ];
        //Send post request
        $response = $this->json('POST',route('user.register.validate'),$data);
        //Assert it was successful
        $response->assertStatus(200);
        //Assert we received a token
        //$this->assertArrayHasKey('token',$response->json());
        
    }
    
    public function testcantRegister(){
        //User's data
        $data = [
            
            'name' => 'Test',
            'username' => 'Test123',
            'phonenumber'=>'1234567890',
            'email'=>'test@gmail.com',
            'password' => 'secret1234',
            'password_confirmation' => '1234',
        ];
        //Send post request
        $response = $this->json('POST',route('user.register.validate'),$data);
        //Assert it was successful
        $response->assertStatus(200);
        //Assert we received a token
        //$this->assertArrayHasKey('token',$response->json());
        
    }
    
    
    
    public function testEmailIsNotString() {
		$data = [
			'name' => 'Test',
            'username' => 'Test123',
            'phonenumber'=>'1234567890',
            'email'=>'123',
            'password' => 'secret1234',
            'password_confirmation' => 'secret1234',
		];
       $response = $this->json('POST',route('user.register.validate'),$data);
       $response->assertStatus(500);
       //$this->assertJson(['email']);
     }
     public function test_password_should_match_with_confirmpassword() {
		$data = [
			'name' => 'Test',
            'username' => 'Test123',
            'phonenumber'=>'1234567890',
            'email'=>'test@123',
            'password' => 'secret1234',
            'password_confirmation' => 'ancdef1234',
		];
       $response = $this->json('POST',route('user.register.validate'),$data);
       $this->withoutMiddleware();
      $response->assertStatus(200);
       //$this->assertJson(['email']);
     }

     public function test_mobile_should_be_10_number() {
		$data = [
			'name' => 'Test',
            'username' => 'Test123',
            'phonenumber'=>'123456',
            'email'=>'test@123',
            'password' => 'secret1234',
            'password_confirmation' => 'ancdef1234',
		];
       $response = $this->json('POST',route('user.register.validate'),$data);
       $this->withoutMiddleware();
      $response->assertStatus(200);
     }
     
   //test case pass
    
    }
