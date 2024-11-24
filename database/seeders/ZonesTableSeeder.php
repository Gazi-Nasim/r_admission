<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class ZonesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('zones')->insert([
            [
                'name'         => 'Dhaka',
            ],
            [
                'name'         => 'Khulna',
            ],
            [
                'name'         => 'Rajshahi',
            ],
            [
                'name'         => 'Rangpur',
            ],
        ]);
    }
}
