<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class YearsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('years')->truncate();

        DB::table('years')->insert([
            [
                'exam'         => 'HSC',
                'year'         => '2023',
                'display_name' => '2023',
            ],
            [
                'exam'         => 'HSC',
                'year'         => '2022',
                'display_name' => '2022',
            ],
            [
                'exam'         => 'SSC',
                'year'         => '2021',
                'display_name' => '2021',
            ],
            [
                'exam'         => 'SSC',
                'year'         => '2020',
                'display_name' => '2020',
            ],
            [
                'exam'         => 'SSC',
                'year'         => '2018',
                'display_name' => '2018',
            ],
            [
                'exam'         => 'SSC',
                'year'         => '2017',
                'display_name' => '2017',
            ],
            [
                'exam'         => 'SSC',
                'year'         => '2016',
                'display_name' => '2016',
            ],
            [
                'exam'         => 'SSC',
                'year'         => '2015',
                'display_name' => '2015',
            ],

            [
                'exam'         => 'SSC',
                'year'         => '2021',
                'display_name' => '2021-IMPROVEMENT',
            ],
        ]);


    }
}
