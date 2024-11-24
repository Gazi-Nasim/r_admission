<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class UnitsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('units')->truncate();

        DB::table('units')->insert(array(
            0 =>
                array(
                    'unit_name'   => 'A',
                    'description' => 'Faulty of Arts, Law, Social Science, Fine Arts, and Institute of Education and Research (IER)',
                ),
            1 =>
                array(
                    'unit_name'   => 'B',
                    'description' => 'Faculty of Business Studies and Institute of Business Administration (IBA)',
                ),
            2 =>
                array(
                    'unit_name'   => 'C',
                    'description' => 'Faculty of Science, Biological Sciences, Agriculture, Engineering, Geosciences, Veterinary & Animal Sciences, and Fisheries',
                ),
        ));


    }
}
