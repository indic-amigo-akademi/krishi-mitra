<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class DBConnectionTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {

        $this->assertNotNull(DB::Connection('mysql'));
        $db_name = DB::connection()->getDatabaseName();
        $this->assertEquals('krishi',$db_name);
    }
}

