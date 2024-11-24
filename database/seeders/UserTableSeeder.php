<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        $data = [
            [
                'username' => 'admin',
                'fullname' => 'admin admin',
                'password' => bcrypt('admin@ru.adm')
            ],
            [
                'username' => 'mki',
                'fullname' => 'Md. Khademul Islam Molla ',
                'password' => bcrypt('admin@ru.adm')
            ],
            [
                'username' => 'sanjoy',
                'fullname' => 'Sanjoy Kumar Chakravarty',
                'password' => bcrypt('admin@ru.adm')
            ],

            [
                'username' => 'operator1',
                'fullname' => 'Operator 1',
                'password' => bcrypt('0paret0r1')
            ]

        ];

        User::insert($data);
    }


}
