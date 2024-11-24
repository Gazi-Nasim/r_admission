<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class GroupsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('groups')->truncate();

        DB::table('groups')->insert(array(
            0  =>
                array(
                    'exam'         => 'SSC',
                    'group_name'   => 'BUSINESS STUDIES',
                    'display_name' => 'BUSINESS STUDIES',
                ),
            1  =>
                array(
                    'exam'         => 'SSC',
                    'group_name'   => 'HUMANITIES',
                    'display_name' => 'HUMANITIES',
                ),
            2  =>
                array(
                    'exam'         => 'SSC',
                    'group_name'   => 'SCIENCE',
                    'display_name' => 'SCIENCE',
                ),
            3  =>
                array(
                    'exam'         => 'SSC',
                    'group_name'   => 'GENERAL',
                    'display_name' => 'GENERAL',
                ),
            4  =>
                array(
                    'exam'         => 'SSC',
                    'group_name'   => 'HIF. QURAN',
                    'display_name' => 'HIF. QURAN',
                ),
            5  =>
                array(
                    'exam'         => 'SSC',
                    'group_name'   => 'MUZABBID',
                    'display_name' => 'MUZABBID',
                ),
            6  =>
                array(
                    'exam'         => 'HSC',
                    'group_name'   => 'BUSINESS STUDIES',
                    'display_name' => 'BUSINESS STUDIES',
                ),
            7  =>
                array(
                    'exam'         => 'HSC',
                    'group_name'   => 'HOME ECONOMICS',
                    'display_name' => 'HOME ECONOMICS',
                ),
            8  =>
                array(
                    'exam'         => 'HSC',
                    'group_name'   => 'HUMANITIES',
                    'display_name' => 'HUMANITIES',
                ),
            9  =>
                array(
                    'exam'         => 'HSC',
                    'group_name'   => 'SCIENCE',
                    'display_name' => 'SCIENCE',
                ),
            10 =>
                array(
                    'exam'         => 'HSC',
                    'group_name'   => 'ISLAMIC STUDIES',
                    'display_name' => 'ISLAMIC STUDIES',
                ),
            11 =>
                array(
                    'exam'         => 'HSC',
                    'group_name'   => 'MUSIC',
                    'display_name' => 'MUSIC',
                ),
            12 =>
                array(
                    'exam'         => 'HSC',
                    'group_name'   => 'GENERAL',
                    'display_name' => 'GENERAL',
                ),
            13 =>
                array(
                    'exam'         => 'HSC',
                    'group_name'   => 'MUZ. (PART)',
                    'display_name' => 'MUZ. (PART)',
                ),
            14 =>
                array(
                    'exam'         => 'HSC',
                    'group_name'   => 'MUZABBID',
                    'display_name' => 'MUZABBID',
                ),
        ));


    }
}
