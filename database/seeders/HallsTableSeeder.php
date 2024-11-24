<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class HallsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('halls')->truncate();

        DB::table('halls')->insert(array(
            0  =>
                array(
                    'name'      => 'Sher-e Bangla Fazlul Haque Hall',
                    'hall_code' => '101',
                    'seats'     => 312,
                    'assigned'  => 161,
                ),
            1  =>
                array(
                    'name'      => 'Shah Makhdum Hall',
                    'hall_code' => '102',
                    'seats'     => 444,
                    'assigned'  => 230,
                ),
            2  =>
                array(
                    'name'      => 'Nawab Abdul Latif Hall',
                    'hall_code' => '103',
                    'seats'     => 319,
                    'assigned'  => 165,
                ),
            3  =>
                array(
                    'name'      => 'Syed Amer Ali Hall',
                    'hall_code' => '104',
                    'seats'     => 410,
                    'assigned'  => 212,
                ),
            4  =>
                array(
                    'name'      => 'Shaheed Shamsuzzoha Hall',
                    'hall_code' => '105',
                    'seats'     => 422,
                    'assigned'  => 218,
                ),
            5  =>
                array(
                    'name'      => 'Shaheed Habibur Rahman Hall',
                    'hall_code' => '106',
                    'seats'     => 728,
                    'assigned'  => 376,
                ),
            6  =>
                array(
                    'name'      => 'Matihar Hall',
                    'hall_code' => '107',
                    'seats'     => 490,
                    'assigned'  => 253,
                ),
            7  =>
                array(
                    'name'      => 'Madar Bux Hall',
                    'hall_code' => '108',
                    'seats'     => 580,
                    'assigned'  => 300,
                ),
            8  =>
                array(
                    'name'      => 'Shaheed Suhrawardy Hall',
                    'hall_code' => '109',
                    'seats'     => 592,
                    'assigned'  => 306,
                ),
            9  =>
                array(
                    'name'      => 'Shaheed Ziaur Rahman Hall',
                    'hall_code' => '110',
                    'seats'     => 598,
                    'assigned'  => 310,
                ),
            10 =>
                array(
                    'name'      => 'Bangabandhu Sheikh Mujibur Rahman Hall',
                    'hall_code' => '111',
                    'seats'     => 496,
                    'assigned'  => 256,
                ),
            11 =>
                array(
                    'name'      => 'Mannujan Hall',
                    'hall_code' => '120',
                    'seats'     => 860,
                    'assigned'  => 420,
                ),
            12 =>
                array(
                    'name'      => 'Rokeya Hall',
                    'hall_code' => '121',
                    'seats'     => 720,
                    'assigned'  => 350,
                ),
            13 =>
                array(
                    'name'      => 'Taposhi Rabeya Hall',
                    'hall_code' => '122',
                    'seats'     => 469,
                    'assigned'  => 150,
                ),
            14 =>
                array(
                    'name'      => 'Begum Khaleda Zia Hall',
                    'hall_code' => '123',
                    'seats'     => 452,
                    'assigned'  => 220,
                ),
            15 =>
                array(
                    'name'      => 'Rahamatunnesa Hall',
                    'hall_code' => '124',
                    'seats'     => 580,
                    'assigned'  => 280,
                ),
            16 =>
                array(
                    'name'      => 'Bangamata Sheikh Fazilatunnesa Hall',
                    'hall_code' => '125',
                    'seats'     => 504,
                    'assigned'  => 242,
                ),
            17 =>
                array(
                    'name'      => 'Shaheed Mir Abdul Quayyum International Dormitory',
                    'hall_code' => '130',
                    'seats'     => 96,
                    'assigned'  => 0,
                ),
            18 =>
                array(
                    'name'      => 'IBS Dormitory',
                    'hall_code' => '131',
                    'seats'     => 0,
                    'assigned'  => 0,
                ),
            19 =>
                array(
                    'name'      => '( IBA )',
                    'hall_code' => '132',
                    'seats'     => 0,
                    'assigned'  => 58,
                ),
        ));


    }
}
