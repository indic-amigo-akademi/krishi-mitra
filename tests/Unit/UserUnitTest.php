<?php

namespace Tests\Unit;

use App\Models\Seller;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\SetupTest;

class UserUnitTest extends TestCase
{
    use RefreshDatabase, SetupTest;

    private Collection $users;
    private Collection $addresses;

    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpUsers();
        $this->setUpAddresses();
    }


    public function testFillableAttributes()
    {
        $fillable = [
            'name',
            'username',
            'email',
            'phone',
            'password',
            'role',
            'active',
        ];
        $this->assertEquals($this->users[0]->getFillable(), $fillable);
    }

    public function testHiddenAttributes()
    {
        $hidden = ['password', 'remember_token'];
        $this->assertEquals($this->users[0]->getHidden(), $hidden);
    }

    public function testCast()
    {
        $casts = [
            'id' => 'int',
            'email_verified_at' => 'datetime',
            'is_sysadmin' => 'boolean',
            'is_admin' => 'boolean',
            'is_seller' => 'boolean',
        ];
        $this->assertEquals($this->users[0]->getCasts(), $casts);
    }

    public function testSellerBelongstoUser()
    {
        $this->assertEquals(
            $this->users[1]->seller->id,
            Seller::all()->sortByDesc('id')
                ->first()->id
        );
    }

    public function testuser_hasmany_address()
    {
        $this->assertEquals($this->addresses[0]->id, $this->users[0]->addresses[0]->id);
        $this->assertEquals($this->addresses[1]->id, $this->users[1]->addresses[0]->id);
        $this->assertCount(
            1,
            $this->users[0]->addresses
        );
    }

    public function test_get_sys_adminattribute()
    {
        $user = new User([
            'role' => 'sysadmin'
        ]);

        $this->assertNotNull($user->role);
        $this->assertEquals("sysadmin", $user->role);
    }

    public function test_get_admin_attribute()
    {
        $user1 = new User(['role' => 'admin']);
        $user2 = new User(['role' => 'sysadmin']);
        $this->assertNotNull($user1->role);
        $this->assertNotNull($user2->role);
        $this->assertEquals("admin", $user1->role);
        $this->assertEquals("sysadmin", $user2->role);
    }

    public function test_get_seller_attribute()
    {
        $user = new User(['role' => 'seller']);
        $this->assertNotNull($user->role);
        $this->assertEquals("seller", $user->role);
    }
}
