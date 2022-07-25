<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert(['title'=>'Super Admin', 'privilege'=>1]);
        DB::table('roles')->insert(['title'=>'Timtable Admin', 'privilege'=>2]);
        DB::table('roles')->insert(['title'=>'Departmental Timtable Officer', 'privilege'=>3]);
        DB::table('roles')->insert(['title'=>'Monitoring Officer', 'privilege'=>4]);
    }
}
