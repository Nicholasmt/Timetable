<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(['name'=>'Super Admin', 'role_id'=>1, 'department_id'=>1, 'email'=>'admin@gmail.com', 'password'=>Hash::make('12345678')]);
        DB::table('users')->insert(['name'=>'Timetable Admin', 'role_id'=>2, 'department_id'=>2, 'email'=>'timetableAdmin@gmail.com', 'password'=>Hash::make('12345678')]);
        DB::table('users')->insert(['name'=>'Departmental Timetable Officer', 'role_id'=>3, 'department_id'=>1, 'email'=>'deptOfficer@gmail.com', 'password'=>Hash::make('12345678')]);
        DB::table('users')->insert(['name'=>'Monitoring Officer', 'role_id'=>4, 'department_id'=>2, 'email'=>'monitoringOfficer@gmail.com', 'password'=>Hash::make('12345678')]);

    }
}
