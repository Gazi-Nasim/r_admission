<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class DistrictsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('districts')->truncate();

        DB::table('districts')->insert(array(
            0  =>
                array(
                    'name'        => 'Barguna',
                    'division_id' => 1,
                ),
            1  =>
                array(
                    'name'        => 'Barisal',
                    'division_id' => 1,
                ),
            2  =>
                array(
                    'name'        => 'Bhola',
                    'division_id' => 1,
                ),
            3  =>
                array(
                    'name'        => 'Jhalokati',
                    'division_id' => 1,
                ),
            4  =>
                array(
                    'name'        => 'Patuakhali',
                    'division_id' => 1,
                ),
            5  =>
                array(
                    'name'        => 'Pirojpur',
                    'division_id' => 1,
                ),
            6  =>
                array(
                    'name'        => 'Bandarban',
                    'division_id' => 2,
                ),
            7  =>
                array(
                    'name'        => 'Brahmanbaria',
                    'division_id' => 2,
                ),
            8  =>
                array(
                    'name'        => 'Chandpur',
                    'division_id' => 2,
                ),
            9  =>
                array(
                    'name'        => 'Chottogram',
                    'division_id' => 2,
                ),
            10 =>
                array(
                    'name'        => 'Comilla',
                    'division_id' => 2,
                ),
            11 =>
                array(
                    'name'        => 'Cox\'s Bazar',
                    'division_id' => 2,
                ),
            12 =>
                array(
                    'name'        => 'Feni',
                    'division_id' => 2,
                ),
            13 =>
                array(
                    'name'        => 'Khagrachhari',
                    'division_id' => 2,
                ),
            14 =>
                array(
                    'name'        => 'Lakshmipur',
                    'division_id' => 2,
                ),
            15 =>
                array(
                    'name'        => 'Noakhali',
                    'division_id' => 2,
                ),
            16 =>
                array(
                    'name'        => 'Rangamati',
                    'division_id' => 2,
                ),
            17 =>
                array(
                    'name'        => 'Dhaka',
                    'division_id' => 3,
                ),
            18 =>
                array(
                    'name'        => 'Faridpur',
                    'division_id' => 3,
                ),
            19 =>
                array(
                    'name'        => 'Gazipur',
                    'division_id' => 3,
                ),
            20 =>
                array(
                    'name'        => 'Gopalganj',
                    'division_id' => 3,
                ),
            21 =>
                array(
                    'name'        => 'Kishoreganj',
                    'division_id' => 3,
                ),
            22 =>
                array(
                    'name'        => 'Madaripur',
                    'division_id' => 3,
                ),
            23 =>
                array(
                    'name'        => 'Manikganj',
                    'division_id' => 3,
                ),
            24 =>
                array(
                    'name'        => 'Munshiganj',
                    'division_id' => 3,
                ),
            25 =>
                array(
                    'name'        => 'Narayanganj',
                    'division_id' => 3,
                ),
            26 =>
                array(
                    'name'        => 'Narsingdi',
                    'division_id' => 3,
                ),
            27 =>
                array(
                    'name'        => 'Rajbari',
                    'division_id' => 3,
                ),
            28 =>
                array(
                    'name'        => 'Shariatpur',
                    'division_id' => 3,
                ),
            29 =>
                array(
                    'name'        => 'Tangail',
                    'division_id' => 3,
                ),
            30 =>
                array(
                    'name'        => 'Bagerhat',
                    'division_id' => 4,
                ),
            31 =>
                array(
                    'name'        => 'Chuadanga',
                    'division_id' => 4,
                ),
            32 =>
                array(
                    'name'        => 'Jessore',
                    'division_id' => 4,
                ),
            33 =>
                array(
                    'name'        => 'Jhenaidah',
                    'division_id' => 4,
                ),
            34 =>
                array(
                    'name'        => 'Khulna',
                    'division_id' => 4,
                ),
            35 =>
                array(
                    'name'        => 'Kushtia',
                    'division_id' => 4,
                ),
            36 =>
                array(
                    'name'        => 'Magura',
                    'division_id' => 4,
                ),
            37 =>
                array(
                    'name'        => 'Meherpur',
                    'division_id' => 4,
                ),
            38 =>
                array(
                    'name'        => 'Narail',
                    'division_id' => 4,
                ),
            39 =>
                array(
                    'name'        => 'Satkhira',
                    'division_id' => 4,
                ),
            40 =>
                array(
                    'name'        => 'Jamalpur',
                    'division_id' => 5,
                ),
            41 =>
                array(
                    'name'        => 'Mymensingh',
                    'division_id' => 5,
                ),
            42 =>
                array(
                    'name'        => 'Netrakona',
                    'division_id' => 5,
                ),
            43 =>
                array(
                    'name'        => 'Sherpur',
                    'division_id' => 5,
                ),
            44 =>
                array(
                    'name'        => 'Bogra',
                    'division_id' => 6,
                ),
            45 =>
                array(
                    'name'        => 'Chapainawabganj',
                    'division_id' => 6,
                ),
            46 =>
                array(
                    'name'        => 'Joypurhat',
                    'division_id' => 6,
                ),
            47 =>
                array(
                    'name'        => 'Naogaon',
                    'division_id' => 6,
                ),
            48 =>
                array(
                    'name'        => 'Natore',
                    'division_id' => 6,
                ),
            49 =>
                array(
                    'name'        => 'Pabna',
                    'division_id' => 6,
                ),
            50 =>
                array(
                    'name'        => 'Rajshahi',
                    'division_id' => 6,
                ),
            51 =>
                array(
                    'name'        => 'Sirajganj',
                    'division_id' => 6,
                ),
            52 =>
                array(
                    'name'        => 'Dinajpur',
                    'division_id' => 7,
                ),
            53 =>
                array(
                    'name'        => 'Gaibandha',
                    'division_id' => 7,
                ),
            54 =>
                array(
                    'name'        => 'Kurigram',
                    'division_id' => 7,
                ),
            55 =>
                array(
                    'name'        => 'Lalmonirhat',
                    'division_id' => 7,
                ),
            56 =>
                array(
                    'name'        => 'Nilphamari',
                    'division_id' => 7,
                ),
            57 =>
                array(
                    'name'        => 'Panchagarh',
                    'division_id' => 7,
                ),
            58 =>
                array(
                    'name'        => 'Rangpur',
                    'division_id' => 7,
                ),
            59 =>
                array(
                    'name'        => 'Thakurgaon',
                    'division_id' => 7,
                ),
            60 =>
                array(
                    'name'        => 'Habiganj',
                    'division_id' => 8,
                ),
            61 =>
                array(
                    'name'        => 'Moulvibazar',
                    'division_id' => 8,
                ),
            62 =>
                array(
                    'name'        => 'Sunamganj',
                    'division_id' => 8,
                ),
            63 =>
                array(
                    'name'        => 'Sylhet',
                    'division_id' => 8,
                ),
        ));


    }
}
