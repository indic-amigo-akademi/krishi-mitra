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
    $tables = array(
        0 => 'addresses',
        1 => 'approvals',
        2 => 'carts',
        3 => 'contacts',
        4 => 'failed_jobs',
        5 => 'file_images',
        6 => 'migrations',
        7 => 'orders',
        8 => 'password_resets',
        9 => 'products',
        10 => 'sellers',
        11 => 'users'
    );
    $tb = array_map('reset', DB::connection('mysql')->select('SHOW TABLES'));
    $this->assertEquals($tables, $tb);
    }
}
