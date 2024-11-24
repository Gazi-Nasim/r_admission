<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class BoardsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('boards')->truncate();

        DB::table('boards')->insert([
            0  =>
                [
                    'exam'         => 'HSC',
                    'board_name'   => 'barishal',
                    'display_name' => 'Barishal',
                ],
            1  =>
                [
                    'exam'         => 'HSC',
                    'board_name'   => 'chittagong',
                    'display_name' => 'Chittagong',
                ],
            2  =>
                [
                    'exam'         => 'HSC',
                    'board_name'   => 'comilla',
                    'display_name' => 'Comilla',
                ],
            3  =>
                [
                    'exam'         => 'HSC',
                    'board_name'   => 'dhaka',
                    'display_name' => 'Dhaka',
                ],
            4  =>
                [
                    'exam'         => 'HSC',
                    'board_name'   => 'dinajpur',
                    'display_name' => 'Dinajpur',
                ],
            5  =>
                [
                    'exam'         => 'HSC',
                    'board_name'   => 'jashore',
                    'display_name' => 'Jashore',
                ],
            6  =>
                [
                    'exam'         => 'HSC',
                    'board_name'   => 'rajshahi',
                    'display_name' => 'Rajshahi',
                ],
            7  =>
                [
                    'exam'         => 'HSC',
                    'board_name'   => 'mymensingh',
                    'display_name' => 'Mymensingh',
                ],
            8  =>
                [
                    'exam'         => 'HSC',
                    'board_name'   => 'sylhet',
                    'display_name' => 'Sylhet',
                ],
            9  =>
                [
                    'exam'         => 'HSC',
                    'board_name'   => 'madrasah',
                    'display_name' => 'Madrasah',
                ],
            10 =>
                [
                    'exam'         => 'HSC',
                    'board_name'   => 'DIBS',
                    'display_name' => 'DIBS',
                ],
            11 =>
                [
                    'exam'         => 'HSC',
                    'board_name'   => 'BTEB',
                    'display_name' => 'Technical-Vocational',
                ],
            12 =>
                [
                    'exam'         => 'HSC',
                    'board_name'   => 'BM/DCOM',
                    'display_name' => 'Technical- (BM/DCOM)',
                ],
            13 =>
                [
                    'exam'         => 'HSC',
                    'board_name'   => 'oth',
                    'display_name' => 'Others (GCE-A Level/Diploma/BFA)',
                ],
            14 =>
                [
                    'exam'         => 'SSC',
                    'board_name'   => 'barishal',
                    'display_name' => 'Barishal',
                ],
            15 =>
                [
                    'exam'         => 'SSC',
                    'board_name'   => 'chittagong',
                    'display_name' => 'Chittagong',
                ],
            16 =>
                [
                    'exam'         => 'SSC',
                    'board_name'   => 'comilla',
                    'display_name' => 'Comilla',
                ],
            17 =>
                [
                    'exam'         => 'SSC',
                    'board_name'   => 'dhaka',
                    'display_name' => 'Dhaka',
                ],
            18 =>
                [
                    'exam'         => 'SSC',
                    'board_name'   => 'dinajpur',
                    'display_name' => 'Dinajpur',
                ],
            19 =>
                [
                    'exam'         => 'SSC',
                    'board_name'   => 'jashore',
                    'display_name' => 'Jashore',
                ],
            20 =>
                [
                    'exam'         => 'SSC',
                    'board_name'   => 'rajshahi',
                    'display_name' => 'Rajshahi',
                ],
            21 =>
                [
                    'exam'         => 'SSC',
                    'board_name'   => 'sylhet',
                    'display_name' => 'Sylhet',
                ],
            22 =>
                [
                    'exam'         => 'SSC',
                    'board_name'   => 'madrasah',
                    'display_name' => 'Madrasah',
                ],
            23 =>
                [
                    'exam'         => 'SSC',
                    'board_name'   => 'TECHNICAL',
                    'display_name' => 'Technical',
                ],
            24 =>
                [
                    'exam'         => 'SSC',
                    'board_name'   => 'oth',
                    'display_name' => 'Other (GCE- O Level)',
                ],
        ]);


    }
}
