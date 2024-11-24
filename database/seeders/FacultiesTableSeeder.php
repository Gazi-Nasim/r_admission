<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class FacultiesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('faculties')->truncate();

        DB::table('faculties')->insert(array(
            0  =>
                array(
                    'faculty_name' => 'Faculty of Arts',
                    'unit_id'      => 1,
                ),
            1  =>
                array(
                    'faculty_name' => 'Faculty of Law',
                    'unit_id'      => 1,
                ),
            2  =>
                array(
                    'faculty_name' => 'Faculty of Science',
                    'unit_id'      => 3,
                ),
            3  =>
                array(
                    'faculty_name' => 'Faculty of Business Studies',
                    'unit_id'      => 2,
                ),
            4  =>
                array(
                    'faculty_name' => 'Faculty of Social Science',
                    'unit_id'      => 1,
                ),
            5  =>
                array(
                    'faculty_name' => 'Faculty of Agriculture',
                    'unit_id'      => 3,
                ),
            6  =>
                array(
                    'faculty_name' => 'Faculty of Biological Sciences',
                    'unit_id'      => 3,
                ),
            7  =>
                array(
                    'faculty_name' => 'Faculty of Geosciences',
                    'unit_id'      => 3,
                ),
            8  =>
                array(
                    'faculty_name' => 'Faculty of Engineering',
                    'unit_id'      => 3,
                ),
            9  =>
                array(
                    'faculty_name' => 'Faculty of Fine Arts',
                    'unit_id'      => 1,
                ),
            10 =>
                array(
                    'faculty_name' => 'Faculty of Fisheries',
                    'unit_id'      => 3,
                ),
            11 =>
                array(
                    'faculty_name' => 'Faculty of  Veterinary and Animal Sciences',
                    'unit_id'      => 3,
                ),
            12 =>
                array(
                    'faculty_name' => 'Institute of Business Administration',
                    'unit_id'      => 2,
                ),
            13 =>
                array(
                    'faculty_name' => 'Institute of Education and Research',
                    'unit_id'      => 1,
                ),
        ));


    }
}
