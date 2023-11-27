<?php

namespace Tests\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;

trait SetupTest
{
    protected function setUpUsers()
    {
        // Create test users
        $this->users = User::factory()
            ->count(4)
            ->state(
                new Sequence(
                    ['role' => 'user'],
                    ['role' => 'seller'],
                    ['role' => 'admin'],
                    ['role' => 'sysadmin'],
                )
            )
            ->create();
    }
}
