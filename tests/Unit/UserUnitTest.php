<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\User;
use App\Seller;
use App\Address;
class UserUnitTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    private $address;
    private $seller;
    protected function setUp(): void
    {
        parent::setUp();

        $this->addresses = new Address();
        $this->seller=new Seller();
         $this->user=new User();
        

        
    }

    
    public function testFillableAttributes()
    {
        $fillable = ['name',
        'username',
        'email',
        'phone',
        'password',
        'role',
        'active',
    ];

        $this->assertEquals($this->user->getFillable(), $fillable);
    }

    public function testHiddenAttributes()
    {
        $hidden = ['password', 'remember_token'];
        $this->assertEquals($this->user->getHidden(),$hidden);
    }
    public function testCast()
    {
        $casts = [
            'id'=>'int',
            'email_verified_at' => 'datetime',
            'is_sysadmin' => 'boolean',
            'is_admin' => 'boolean',
            'is_seller' => 'boolean',
        ];
        $this->assertEquals($this->user->getCasts(),$casts);
    }
    public function testseller_hasone_userid()
    {
        $user = new User();
        $seller = new Seller(['user_id' => $user->id]);
        $testArray = array($seller);
        $expectcount=1;
        $this->assertEquals($this->seller->user_id,$user->id);
        
        $this->assertCount(
            $expectcount,
            $testArray
        );
        
        


    }
    public function testuser_hasmany_address()
    {
        /*$user=new User();
        $address=new Address(['user_id' => $user->id]);
       
        $this->assertEquals($user->id, $address->user_id);*/
        
       // $user=new User();
        //$this->assertEquals($user->id, $this->addresses->user_id);
        $user = new User();
        $address=new Address(['user_id' => $user->id]);
        $address1=new Address(['user_id' => $user->id]);
        $testArray = array($address,$address1);
        $expectedCount = 2;
        //$this->assertEquals($this->addresses->user_id,$user->id);
         $this->assertEquals($this->addresses->user_id,$address->user_id);
        $this->assertEquals($this->addresses->user_id,$address1->user_id);
        $this->assertCount(
            $expectedCount,
            $testArray
        );

    }
    public function test_get_sys_adminattribute()
    {
        $user =new User([
            'role'=>'sysadmin'
        ]);

        $this->assertNotNull($user->role);
        $this->assertEquals("sysadmin", $user->role);  
    }
    public function test_get_admin_attribute()
    {
        $user1=new User(['role'=>'admin']);
        $user2=new User(['role'=>'sysadmin']);
        $this->assertNotNull($user1->role);
        $this->assertNotNull($user2->role);
        $this->assertEquals("admin",$user1->role);
        $this->assertEquals("sysadmin",$user2->role);
    }
    public function test_get_seller_attribute()
    {
        $user=new User(['role'=>'seller']);
        $this->assertNotNull($user->role);
        $this->assertEquals("seller",$user->role);
    }
}
