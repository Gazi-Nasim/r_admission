<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class AdmissionFeesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('admission_fees')->delete();

        DB::table('admission_fees')->insert([
            0 =>
                [
                    'unit_name' => 'A',
                    'amount'    => 1320.0,
                ],
            1 =>
                [
                    'unit_name' => 'B',
                    'amount'    => 1100.0,
                ],
            2 =>
                [
                    'unit_name' => 'C',
                    'amount'    => 1320.0,
                ],
        ]);


    }
}
