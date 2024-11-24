<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class DepartmentsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('departments')->truncate();

        DB::table('departments')->insert(array(
            0  =>
                array(
                    'name'        => 'Philosophy',
                    'dept_code'   => '01',
                    'faculty_id'  => 1,
                    'seats'       => 110,
                    'degree_name' => 'B.A',
                    'short_name'  => NULL,
                ),
            1  =>
                array(
                    'name'        => 'History',
                    'dept_code'   => '02',
                    'faculty_id'  => 1,
                    'seats'       => 110,
                    'degree_name' => 'B.A',
                    'short_name'  => NULL,
                ),
            2  =>
                array(
                    'name'        => 'English',
                    'dept_code'   => '03',
                    'faculty_id'  => 1,
                    'seats'       => 100,
                    'degree_name' => 'B.A',
                    'short_name'  => NULL,
                ),
            3  =>
                array(
                    'name'        => 'Bangla',
                    'dept_code'   => '04',
                    'faculty_id'  => 1,
                    'seats'       => 100,
                    'degree_name' => 'B.A',
                    'short_name'  => NULL,
                ),
            4  =>
                array(
                    'name'        => 'Islamic History and Culture',
                    'dept_code'   => '05',
                    'faculty_id'  => 1,
                    'seats'       => 110,
                    'degree_name' => 'B.A',
                    'short_name'  => NULL,
                ),
            5  =>
                array(
                    'name'        => 'Arabic',
                    'dept_code'   => '07',
                    'faculty_id'  => 1,
                    'seats'       => 110,
                    'degree_name' => 'B.A',
                    'short_name'  => NULL,
                ),
            6  =>
                array(
                    'name'        => 'Islamic Studies',
                    'dept_code'   => '09',
                    'faculty_id'  => 1,
                    'seats'       => 110,
                    'degree_name' => 'B.A',
                    'short_name'  => NULL,
                ),
            7  =>
                array(
                    'name'        => 'Theatre',
                    'dept_code'   => '10',
                    'faculty_id'  => 1,
                    'seats'       => 25,
                    'degree_name' => 'B.P.A',
                    'short_name'  => NULL,
                ),
            8  =>
                array(
                    'name'        => 'Music',
                    'dept_code'   => '11',
                    'faculty_id'  => 1,
                    'seats'       => 30,
                    'degree_name' => 'B.P.A',
                    'short_name'  => NULL,
                ),
            9  =>
                array(
                    'name'        => 'Persian Language and Literature',
                    'dept_code'   => '12',
                    'faculty_id'  => 1,
                    'seats'       => 40,
                    'degree_name' => 'B.A',
                    'short_name'  => NULL,
                ),
            10 =>
                array(
                    'name'        => 'Sanskrit',
                    'dept_code'   => '13',
                    'faculty_id'  => 1,
                    'seats'       => 56,
                    'degree_name' => 'B.A',
                    'short_name'  => NULL,
                ),
            11 =>
                array(
                    'name'        => 'Urdu',
                    'dept_code'   => '14',
                    'faculty_id'  => 1,
                    'seats'       => 40,
                    'degree_name' => 'B.A',
                    'short_name'  => NULL,
                ),
            12 =>
                array(
                    'name'        => 'Law',
                    'dept_code'   => '16',
                    'faculty_id'  => 2,
                    'seats'       => 110,
                    'degree_name' => 'LLB (Honors)',
                    'short_name'  => NULL,
                ),
            13 =>
                array(
                    'name'        => 'Law and Land Administration',
                    'dept_code'   => '17',
                    'faculty_id'  => 2,
                    'seats'       => 50,
                    'degree_name' => 'LLB (Honors)',
                    'short_name'  => NULL,
                ),
            14 =>
                array(
                    'name'        => 'Mathematics',
                    'dept_code'   => '21',
                    'faculty_id'  => 3,
                    'seats'       => 110,
                    'degree_name' => 'B.Sc.',
                    'short_name'  => 'MAT',
                ),
            15 =>
                array(
                    'name'        => 'Physics',
                    'dept_code'   => '22',
                    'faculty_id'  => 3,
                    'seats'       => 90,
                    'degree_name' => 'B.Sc.',
                    'short_name'  => 'PHY',
                ),
            16 =>
                array(
                    'name'        => 'Chemistry',
                    'dept_code'   => '23',
                    'faculty_id'  => 3,
                    'seats'       => 100,
                    'degree_name' => 'B.Sc.',
                    'short_name'  => 'CHE',
                ),
            17 =>
                array(
                    'name'        => 'Statistics',
                    'dept_code'   => '24',
                    'faculty_id'  => 3,
                    'seats'       => 90,
                    'degree_name' => 'B.Sc.',
                    'short_name'  => 'STA',
                ),
            18 =>
                array(
                    'name'        => 'Biochemistry and Molecular Biology',
                    'dept_code'   => '25',
                    'faculty_id'  => 3,
                    'seats'       => 50,
                    'degree_name' => 'B.Sc.',
                    'short_name'  => 'BIO',
                ),
            19 =>
                array(
                    'name'        => 'Pharmacy',
                    'dept_code'   => '26',
                    'faculty_id'  => 3,
                    'seats'       => 50,
                    'degree_name' => 'B.Pharm.',
                    'short_name'  => 'PHA',
                ),
            20 =>
                array(
                    'name'        => 'Population Science and Human Resource Development',
                    'dept_code'   => '27',
                    'faculty_id'  => 3,
                    'seats'       => 60,
                    'degree_name' => 'B.Sc.',
                    'short_name'  => 'POP',
                ),
            21 =>
                array(
                    'name'        => 'Applied Mathematics',
                    'dept_code'   => '28',
                    'faculty_id'  => 3,
                    'seats'       => 80,
                    'degree_name' => 'B.Sc.',
                    'short_name'  => 'APM',
                ),
            22 =>
                array(
                    'name'        => 'Physical Education and Sports Science',
                    'dept_code'   => '29',
                    'faculty_id'  => 3,
                    'seats'       => 30,
                    'degree_name' => 'B.Sc.',
                    'short_name'  => 'PES',
                ),
            23 =>
                array(
                    'name'        => 'Accounting and Information Systems',
                    'dept_code'   => '33',
                    'faculty_id'  => 4,
                    'seats'       => 110,
                    'degree_name' => 'B.B.A',
                    'short_name'  => NULL,
                ),
            24 =>
                array(
                    'name'        => 'Management Studies',
                    'dept_code'   => '34',
                    'faculty_id'  => 4,
                    'seats'       => 100,
                    'degree_name' => 'B.B.A',
                    'short_name'  => NULL,
                ),
            25 =>
                array(
                    'name'        => 'Marketing',
                    'dept_code'   => '35',
                    'faculty_id'  => 4,
                    'seats'       => 110,
                    'degree_name' => 'B.B.A',
                    'short_name'  => NULL,
                ),
            26 =>
                array(
                    'name'        => 'Finance',
                    'dept_code'   => '36',
                    'faculty_id'  => 4,
                    'seats'       => 100,
                    'degree_name' => 'B.B.A',
                    'short_name'  => NULL,
                ),
            27 =>
                array(
                    'name'        => 'Banking and Insurance',
                    'dept_code'   => '37',
                    'faculty_id'  => 4,
                    'seats'       => 60,
                    'degree_name' => 'B.B.A',
                    'short_name'  => NULL,
                ),
            28 =>
                array(
                    'name'        => 'Tourism and Hospitality Management',
                    'dept_code'   => '38',
                    'faculty_id'  => 4,
                    'seats'       => 30,
                    'degree_name' => 'B.B.A',
                    'short_name'  => NULL,
                ),
            29 =>
                array(
                    'name'        => 'Economics',
                    'dept_code'   => '42',
                    'faculty_id'  => 5,
                    'seats'       => 110,
                    'degree_name' => 'B.S.S.',
                    'short_name'  => NULL,
                ),
            30 =>
                array(
                    'name'        => 'Political Science',
                    'dept_code'   => '43',
                    'faculty_id'  => 5,
                    'seats'       => 110,
                    'degree_name' => 'B.S.S.',
                    'short_name'  => NULL,
                ),
            31 =>
                array(
                    'name'        => 'Social Work',
                    'dept_code'   => '44',
                    'faculty_id'  => 5,
                    'seats'       => 90,
                    'degree_name' => 'B.S.S.',
                    'short_name'  => NULL,
                ),
            32 =>
                array(
                    'name'        => 'Sociology',
                    'dept_code'   => '45',
                    'faculty_id'  => 5,
                    'seats'       => 100,
                    'degree_name' => 'B.S.S.',
                    'short_name'  => NULL,
                ),
            33 =>
                array(
                    'name'        => 'Mass Communication and Journalism',
                    'dept_code'   => '46',
                    'faculty_id'  => 5,
                    'seats'       => 50,
                    'degree_name' => 'B.S.S.',
                    'short_name'  => NULL,
                ),
            34 =>
                array(
                    'name'        => 'Information Science and Library Management',
                    'dept_code'   => '47',
                    'faculty_id'  => 5,
                    'seats'       => 66,
                    'degree_name' => 'B.S.S.',
                    'short_name'  => NULL,
                ),
            35 =>
                array(
                    'name'        => 'Public Administration',
                    'dept_code'   => '48',
                    'faculty_id'  => 5,
                    'seats'       => 60,
                    'degree_name' => 'B.S.S.',
                    'short_name'  => NULL,
                ),
            36 =>
                array(
                    'name'        => 'Anthropology',
                    'dept_code'   => '49',
                    'faculty_id'  => 5,
                    'seats'       => 56,
                    'degree_name' => 'B.S.S.',
                    'short_name'  => NULL,
                ),
            37 =>
                array(
                    'name'        => 'Folklore',
                    'dept_code'   => '50',
                    'faculty_id'  => 5,
                    'seats'       => 66,
                    'degree_name' => 'B.S.S.',
                    'short_name'  => NULL,
                ),
            38 =>
                array(
                    'name'        => 'International Relations',
                    'dept_code'   => '51',
                    'faculty_id'  => 5,
                    'seats'       => 40,
                    'degree_name' => 'B.S.S.',
                    'short_name'  => NULL,
                ),
            39 =>
                array(
                    'name'        => 'Agronomy and Agricultural Extension',
                    'dept_code'   => '66',
                    'faculty_id'  => 6,
                    'seats'       => 56,
                    'degree_name' => 'B.Sc.',
                    'short_name'  => 'AGR',
                ),
            40 =>
                array(
                    'name'        => 'Crop Science and Technology',
                    'dept_code'   => '69',
                    'faculty_id'  => 6,
                    'seats'       => 56,
                    'degree_name' => 'B.Sc.',
                    'short_name'  => 'CRP',
                ),
            41 =>
                array(
                    'name'        => 'Psychology',
                    'dept_code'   => '57',
                    'faculty_id'  => 7,
                    'seats'       => 70,
                    'degree_name' => 'B.Sc.',
                    'short_name'  => 'PSY',
                ),
            42 =>
                array(
                    'name'        => 'Botany',
                    'dept_code'   => '58',
                    'faculty_id'  => 7,
                    'seats'       => 70,
                    'degree_name' => 'B.Sc.',
                    'short_name'  => 'BOT',
                ),
            43 =>
                array(
                    'name'        => 'Zoology',
                    'dept_code'   => '59',
                    'faculty_id'  => 7,
                    'seats'       => 80,
                    'degree_name' => 'B.Sc.',
                    'short_name'  => 'ZOO',
                ),
            44 =>
                array(
                    'name'        => 'Genetic Engineering and Biotechnology',
                    'dept_code'   => '61',
                    'faculty_id'  => 7,
                    'seats'       => 40,
                    'degree_name' => 'B.Sc.',
                    'short_name'  => 'GEB',
                ),
            45 =>
                array(
                    'name'        => 'Clinical Psychology',
                    'dept_code'   => '62',
                    'faculty_id'  => 7,
                    'seats'       => 30,
                    'degree_name' => 'B.Sc.',
                    'short_name'  => 'CLI',
                ),
            46 =>
                array(
                    'name'        => 'Microbiology',
                    'dept_code'   => '63',
                    'faculty_id'  => 7,
                    'seats'       => 30,
                    'degree_name' => 'B.Sc.',
                    'short_name'  => 'MIC',
                ),
            47 =>
                array(
                    'name'        => 'Geography and Environmental Studies',
                    'dept_code'   => '56',
                    'faculty_id'  => 8,
                    'seats'       => 76,
                    'degree_name' => 'B.Sc.',
                    'short_name'  => 'GES',
                ),
            48 =>
                array(
                    'name'        => 'Geology and Mining',
                    'dept_code'   => '60',
                    'faculty_id'  => 8,
                    'seats'       => 60,
                    'degree_name' => 'B.Sc.',
                    'short_name'  => 'GEM',
                ),
            49 =>
                array(
                    'name'        => 'Applied Chemistry and Chemical Engineering',
                    'dept_code'   => '75',
                    'faculty_id'  => 9,
                    'seats'       => 70,
                    'degree_name' => 'B.Eng.',
                    'short_name'  => 'ACE',
                ),
            50 =>
                array(
                    'name'        => 'Computer Science and Engineering',
                    'dept_code'   => '76',
                    'faculty_id'  => 9,
                    'seats'       => 50,
                    'degree_name' => 'B.Eng.',
                    'short_name'  => 'CSE',
                ),
            51 =>
                array(
                    'name'        => 'Information and Communication Engineering',
                    'dept_code'   => '77',
                    'faculty_id'  => 9,
                    'seats'       => 46,
                    'degree_name' => 'B.Eng.',
                    'short_name'  => 'ICE',
                ),
            52 =>
                array(
                    'name'        => 'Materials Science and Engineering',
                    'dept_code'   => '78',
                    'faculty_id'  => 9,
                    'seats'       => 50,
                    'degree_name' => 'B.Eng.',
                    'short_name'  => 'MSE',
                ),
            53 =>
                array(
                    'name'        => 'Electrical and Electronic Engineering',
                    'dept_code'   => '79',
                    'faculty_id'  => 9,
                    'seats'       => 50,
                    'degree_name' => 'B.Eng.',
                    'short_name'  => 'EEE',
                ),
            54 =>
                array(
                    'name'        => 'Painting, Oriental Art and Printmaking',
                    'dept_code'   => '93',
                    'faculty_id'  => 10,
                    'seats'       => 45,
                    'degree_name' => 'B.F.A.',
                    'short_name'  => NULL,
                ),
            55 =>
                array(
                    'name'        => 'Ceramics and Sculpture',
                    'dept_code'   => '94',
                    'faculty_id'  => 10,
                    'seats'       => 30,
                    'degree_name' => 'B.F.A.',
                    'short_name'  => NULL,
                ),
            56 =>
                array(
                    'name'        => 'Graphic Design, Crafts and History of Art',
                    'dept_code'   => '95',
                    'faculty_id'  => 10,
                    'seats'       => 45,
                    'degree_name' => 'B.F.A.',
                    'short_name'  => NULL,
                ),
            57 =>
                array(
                    'name'        => 'Fisheries',
                    'dept_code'   => '67',
                    'faculty_id'  => 11,
                    'seats'       => 50,
                    'degree_name' => 'B.Sc.',
                    'short_name'  => 'FIS',
                ),
            58 =>
                array(
                    'name'        => 'Veterinary and Animal Sciences',
                    'dept_code'   => '68',
                    'faculty_id'  => 12,
                    'seats'       => 50,
                    'degree_name' => 'DVM',
                    'short_name'  => 'VET',
                ),
            59 =>
                array(
                    'name'        => 'Institute of Business Administration',
                    'dept_code'   => '85',
                    'faculty_id'  => 13,
                    'seats'       => 50,
                    'degree_name' => 'B.B.A',
                    'short_name'  => NULL,
                ),
            60 =>
                array(
                    'name'        => 'Institute of Education and Research',
                    'dept_code'   => '87',
                    'faculty_id'  => 14,
                    'seats'       => 50,
                    'degree_name' => 'B.Ed.(Hons)',
                    'short_name'  => NULL,
                ),
        ));


    }
}
