<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class DBTablesTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $tables = ['addresses', 'carts', 'failed_jobs', 'migrations', 'orders', 'password_resets', 'products', 'sellers', 'users'];
        $tb = array_map('reset',DB::connection('mysql')->select('SHOW TABLES'));
        $this->assertEquals($tables, $tb);
    }
}
