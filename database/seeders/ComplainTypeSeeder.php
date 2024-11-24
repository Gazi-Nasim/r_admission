<?php

namespace Database\Seeders;

use App\Models\ComplainType;
use Illuminate\Database\Seeder;

class ComplainTypeSeeder extends Seeder
{
    public function run(): void
    {
        ComplainType::truncate();


        $data = [
            ['id'=>1 ,'name' => 'নাম পরিবর্তন সংক্রান্ত'],
            ['id'=>2 ,'name' => 'HSC/SSC তথ্য ডেটাবেজে নেই'],
            ['id'=>3 ,'name' => 'পেমেন্ট সংক্রান্ত'],
            ['id'=>4 ,'name' => 'ফটো সংক্রান্ত'],
            ['id'=>5 ,'name' => 'কোটা সংক্রান্ত'],
            ['id'=>6 ,'name' => 'প্রশ্নপত্রের ভাষা পরিবর্তন সংক্রান্ত'],
            ['id'=>50,'name' => 'অন্যান্য'],
        ];

        ComplainType::insert($data);

    }
}
