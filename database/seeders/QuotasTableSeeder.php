<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class QuotasTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('quotas')->truncate();

        DB::table('quotas')->insert(array(
            0 =>
                array(
                    'code'  => 'FFQ',
                    'quota' => 'Freedom Fighter',
                ),
            1 =>
                array(
                    'code'  => 'WQ',
                    'quota' => 'Ward',
                ),
            2 =>
                array(
                    'code'  => 'PDQ',
                    'quota' => 'Physically Disabled',
                ),
            3 =>
                array(
                    'code'  => 'SEQ',
                    'quota' => 'Tribal',
                ),
        ));


    }
}
