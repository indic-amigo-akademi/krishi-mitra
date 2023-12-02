<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\SetupTest;

class LoginTest extends TestCase
{
    use RefreshDatabase, SetupTest;
    private Collection $users;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->setUpUsers();
    }

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
        //attempt login
        $response = $this->json('POST', route('user.login.validate'), [
            'email' => $this->users[0]->email,
            'password' => User::factory()->passwordStr(),
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
        //attempt login
        $response = $this->json('POST', route('user.login.validate'), [
            'email' => $this->users[0]->username,
            'password' => User::factory()->passwordStr(),
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
        //attempt login
        $response = $this->json('POST', route('user.login.validate'), [
            'email' => User::factory()->make()->email,
            'password' => User::factory()->passwordStr(),
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
