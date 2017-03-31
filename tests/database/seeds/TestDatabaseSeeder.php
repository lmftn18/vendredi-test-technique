<?php

namespace Tests\Database\Seeds;

use Illuminate\Database\Seeder;
use \Illuminate\Database\Eloquent\Model;

class TestDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(TestModelSeeder::class);
    }
}
