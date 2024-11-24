<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class DivisionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('divisions')->truncate();

        DB::table('divisions')->insert(array(
            0 =>
                array(
                    'name' => 'Barisal',
                ),
            1 =>
                array(
                    'name' => 'Chittagong',
                ),
            2 =>
                array(
                    'name' => 'Dhaka',
                ),
            3 =>
                array(
                    'name' => 'Khulna',
                ),
            4 =>
                array(
                    'name' => 'Mymensingh',
                ),
            5 =>
                array(
                    'name' => 'Rajshahi',
                ),
            6 =>
                array(
                    'name' => 'Rangpur',
                ),
            7 =>
                array(
                    'name' => 'Sylhet',
                ),
        ));


    }
}
