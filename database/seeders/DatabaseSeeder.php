<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            UserTableSeeder::class,
            LaratrustSeeder::class,
        ]);

        $this->call(BoardsTableSeeder::class);
        $this->call(YearsTableSeeder::class);
        $this->call(UnitsTableSeeder::class);
        $this->call(QuotasTableSeeder::class);
        $this->call(FacultiesTableSeeder::class);
        $this->call(DepartmentsTableSeeder::class);
        $this->call(AdmissionFeesTableSeeder::class);
        $this->call(DistrictsTableSeeder::class);
        $this->call(DivisionsTableSeeder::class);
        $this->call(HallsTableSeeder::class);
        $this->call(GroupsTableSeeder::class);
        $this->call(RegistrationFeesTableSeeder::class);
        $this->call(HscTableSeeder::class);
        $this->call(SettingsTableSeeder::class);
        $this->call(ComplainTypeSeeder::class);
        $this->call(ZonesTableSeeder::class);
    }
}
