<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class LaratrustSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->truncateLaratrustTables();

        // Create Roles
        $admin = Role::create([
            'name'         => 'Admin',
            'display_name' => 'Admin',
            'description'  => 'Admin Role',
        ]);

        $operator = Role::create([
            'name'         => 'Operator',
            'display_name' => 'Operator',
            'description'  => 'Operator User',
        ]);

        $unitOffice = Role::create([
            'name'         => 'UnitOffice',
            'display_name' => 'Unit Office',
            'description'  => 'Unit Office User',
        ]);


        //==== User ====
        // Admin     => 1
        // Opeartor1 => 2

        // attach roll to users
        $admin_ids = [1, 2, 3];
        foreach ($admin_ids as $id) {
            $AdminUser = User::find($id);
            $AdminUser->attachRole($admin);
        }

        $operator_ids = [4];
        foreach ($operator_ids as $id) {
            $operator1 = User::find($id);
            $operator1->attachRole($operator);
        }

    }

    /**
     * Truncates all the laratrust tables and the users table
     *
     * @return  void
     */
    public function truncateLaratrustTables()
    {
        $this->command->info('Truncating User, Role and Permission tables');
        Schema::disableForeignKeyConstraints();

        DB::table('permission_role')->truncate();
        DB::table('permission_user')->truncate();
        DB::table('role_user')->truncate();

        DB::table('roles')->truncate();
        DB::table('permissions')->truncate();

        Schema::enableForeignKeyConstraints();
    }
}
