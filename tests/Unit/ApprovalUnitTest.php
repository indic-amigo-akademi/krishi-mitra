<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Approval;
use App\User;
class ApprovalUnitTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->user=new user();
        $this->approval=new Approval();
        
    }



    public function testFillableAttributes()
    {
        $fillable = [ 'user_id', 'type'];

        $this->assertEquals($this->approval->getFillable(), $fillable);
    }

    public function test_approval_belongsto_user()
    {
        $approval=new Approval();
        $this->assertEquals($approval->user_id, $this->user->id);
    }
}
