<?php

namespace Tests\Feature;

use App\Models\User;

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
    public function testMustEnterEmailAndPassword()
    {
        $this->json('POST', 'user.login.validate')  //if empty
            ->assertStatus(404);
    }

    public function testlogin()
    {

        //Create user
        $data = [
            'name' => 'Test',
            'username' => 'Test123',
            'phonenumber' => '1234567890',
            'email' => 'test@gmail.com',
            'password' => 'secret1234',
            'password_confirmation' => 'secret1234',
        ];
        //attempt login
        $response = $this->json('POST', route('user.login.validate'), [
            'email' => 'test@gmail.com',
            'password' => 'secret1234',
        ]);
        //Assert it was successful 
        $response->assertStatus(200);
    }

    //invalid credentials

    public function testEmailDoesNotExist()
    {
        //Create user
        $data = [
            'name' => 'Test',
            'username' => 'Test123',
            'phonenumber' => '1234567890',
            'email' => 'test@gmail.com',
            'password' => 'secret1234',
            'password_confirmation' => 'secret1234',
        ];
        $response = $this->json('POST', route('user.login.validate'), [
            'email' => 'test@123',
            'password' => 'secret1234',
        ]);
        //Assert it was successful 
        $response->assertStatus(200);
    }



    public function testPasswordDoesNotExist()
    {

        $data = [
            'name' => 'Test',
            'username' => 'Test123',
            'phonenumber' => '1234567890',
            'email' => 'test@gmail.com',
            'password' => 'secret1234',
            'password_confirmation' => 'secret1234',
        ];
        $response = $this->json('POST', route('user.login.validate'), [
            'email' => 'test@123',
            'password' => 'abc1234',
        ]);
        //Assert it was successful 

        $response->assertStatus(200);
    }




    /*  public function deactivatedadminCannotLogin()
    {
        $user = user::factory()->create([
            'email' => 'test@gmail',
            'password' => Hash::make('abc123'),
            'deactivated_at' => now()->subDays(1),
        ]);

        $this->postJson('user.login.validate', [
            'email' => 'test@gmail',
            'password' => 'abc123',
        ])->assertStatus(422)
            ->assertJson([
                'inactive' => 'Your account has been blocked. Please contact the administrators.',
            ]);
    }*/
}
