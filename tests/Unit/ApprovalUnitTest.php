<?php

namespace Tests\Unit;

use App\Models\Approval;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApprovalUnitTest extends TestCase
{
    use RefreshDatabase;
    private $user, $approval;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->approval = Approval::factory()->make();
    }

    public function testFillableAttributes()
    {
        $fillable = ['user_id', 'type'];

        $this->assertEquals($this->approval->getFillable(), $fillable);
    }

    public function testApprovalBelongstoUser()
    {
        $approval = Approval::factory()->create([
            'user_id' => $this->user->id
        ]);
        $this->assertEquals($approval->user_id, $this->user->id);
    }
}
