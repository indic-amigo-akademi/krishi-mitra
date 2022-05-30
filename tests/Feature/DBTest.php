<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class DBTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Test if the database connection is working.
     *
     * @return void
     */
    public function testDBConnection()
    {
        $this->assertNotNull(DB::connection(env('DB_CONNECTION')));
        $db_name = DB::connection(env('DB_CONNECTION'))->getDatabaseName();
        $this->assertEquals(env('DB_DATABASE'), $db_name);
    }
    
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testTablesExists()
    {
        $found_tables = DB::connection(env('DB_CONNECTION'))->getDoctrineSchemaManager()->listTableNames();
        $expected_tables = [
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
            11 => 'users',
        ];
        foreach ($expected_tables as $table) {
            $this->assertContains($table, $found_tables);
        }
    }
}
