<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test login without email or password.
     * 
     * @return void
     */
    public function testLoginWithoutEmailAndPassword()
    {
        $this->json('POST', route('user.login.validate'))  //if empty
            ->assertStatus(200)
            ->assertJson([
                'success' => false,
                'errors' => [
                    'email' => ['The email field is required.'],
                    'password' => ['The password field is required.'],
                ],
            ]);
    }

    /**
     * Test login without email.
     * 
     * @return void
     */
    public function testLoginWithoutEmail()
    {
        $this->json('POST', route('user.login.validate'), ['password' => 'secret'])  //if email empty
            ->assertStatus(200)
            ->assertJson([
                'success' => false,
                'errors' => [
                    'email' => ['The email field is required.'],
                ],
            ]);
    }

    /**
     * Test login without password.
     * 
     * @return void
     */
    public function testLoginWithoutPassword()
    {
        $this->json('POST', route('user.login.validate'), [
            'email' => User::factory()->make()->email, //if password empty
        ])
            ->assertStatus(200)
            ->assertJson([
                'success' => false,
                'errors' => [
                    'password' => ['The password field is required.'],
                ],
            ]);
    }

    /**
     * Test login with valid email and password.
     * 
     * @return void
     */
    public function testLoginWithValidEmailAndPassword()
    {
        //Create user
        $user = User::factory()->create();

        //attempt login
        $response = $this->json('POST', route('user.login.validate'), [
            'email' => $user->email,
            'password' => User::factory()->password_str,
        ]); // if with valid email and password

        //Assert it was successful 
        $response->assertStatus(200);

        // Assert that the response with json
        $response->assertJson([
            'success' => true,
            'message' => 'All fields are valid.',
        ]);
    }

    /**
     * Test login with valid username and password.
     * 
     * @return void
     */
    public function testLoginWithValidUsernameAndPassword()
    {
        //Create user
        $user = User::factory()->create();

        //attempt login
        $response = $this->json('POST', route('user.login.validate'), [
            'email' => $user->username,
            'password' => User::factory()->password_str,
        ]); // if with valid username and password

        //Assert it was successful
        $response->assertStatus(200);

        // Assert that the response with json
        $response->assertJson([
            'success' => true,
            'message' => 'All fields are valid.',
        ]);
    }

    /**
     * Test login with invalid email.
     * 
     * @return void
     */
    public function testLoginWithInvalidEmail()
    {
        //Create user
        $user = User::factory()->create();

        //attempt login
        $response = $this->json('POST', route('user.login.validate'), [
            'email' => User::factory()->make()->email,
            'password' => User::factory()->password_str,
        ]); // if with invalid email

        //Assert it was successful 
        $response->assertStatus(200);

        // Assert that the response with json
        $response->assertJson([
            'success' => false,
            'errors' => ['email' => 'Invalid credentials.'],
        ]);
    }

    /**
     * Test login with invalid password.
     * 
     * @return void
     */
    public function testLoginWithInvalidPassword()
    {
        //Create user
        $user = User::factory()->create();

        //attempt login
        $response = $this->json('POST', route('user.login.validate'), [
            'email' => $user->email,
            'password' => 'password',
        ]); // if with invalid password

        //Assert it was successful 
        $response->assertStatus(200);

        // Assert that the response with json
        $response->assertJson([
            'success' => false,
            'errors' => ['email' => 'Invalid credentials.'],
        ]);
    }
}
