<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Carbon\Carbon;


class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_roles')->insert([
            'id' => '1',
            'name' => 'CEO',
            'access' => ' {"user" : {"create":true, "view":true}}',
        ]);
        DB::table('user_roles')->insert([
            'id' => '2',
            'name' => 'Manager',
            'access' => '{"user": {"create": false, "view": true}}',
        ]);
        DB::table('user_roles')->insert([
            'id' => '3',
            'name' => 'Office',
            'access' => '{"user": {"create": false, "view": false}}',
        ]);
    }
}
