<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class RegistrationFeesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('registration_fees')->truncate();

        DB::table('registration_fees')->insert(array(
            0 =>
                array(
                    'unit_name' => 'A',
                    'amount'    => 4910.0,
                ),
            1 =>
                array(
                    'unit_name' => 'B',
                    'amount'    => 4910.0,
                ),
            2 =>
                array(
                    'unit_name' => 'C',
                    'amount'    => 5035.0,
                ),
            3 =>
                array(
                    'unit_name' => 'D',
                    'amount'    => 0.0,
                ),
            4 =>
                array(
                    'unit_name' => 'E',
                    'amount'    => 0.0,
                ),
        ));


    }
}
