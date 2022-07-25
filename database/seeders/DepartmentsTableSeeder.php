<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departments')->insert(['title'=>'Computer Science','active'=>1]);
        DB::table('departments')->insert(['title'=>'Med Lab','active'=>1]);
    }
}
