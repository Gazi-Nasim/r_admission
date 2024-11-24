<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('settings')->delete();
        
        \DB::table('settings')->insert(array (
            0 => 
            array (
                'id' => 1,
                'key' => 'activate_preliminary_application',
                'value' => '1',
            ),
            1 => 
            array (
                'id' => 2,
                'key' => 'activate_final_application',
                'value' => '0',
            ),
            2 => 
            array (
                'id' => 3,
                'key' => 'activate_post_application',
                'value' => '0',
            ),
            3 => 
            array (
                'id' => 4,
                'key' => 'activate_subject_choice',
                'value' => '0',
            ),
            4 => 
            array (
                'id' => 5,
                'key' => 'allow_application_submission',
                'value' => '1',
            ),
            5 => 
            array (
                'id' => 6,
                'key' => 'allow_application_payment',
                'value' => '1',
            ),
            6 => 
            array (
                'id' => 7,
                'key' => 'allow_photo_change',
                'value' => '1',
            ),
            7 => 
            array (
                'id' => 8,
                'key' => 'photo_change_needs_payment',
                'value' => '0',
            ),
            8 => 
            array (
                'id' => 9,
                'key' => 'allow_quota_update',
                'value' => '1',
            ),
            9 => 
            array (
                'id' => 10,
                'key' => 'allow_question_language_update',
                'value' => '1',
            ),
            10 => 
            array (
                'id' => 11,
                'key' => 'show_homepage_popup',
                'value' => '0',
            ),
            11 => 
            array (
                'id' => 12,
                'key' => 'allow_subject_choice_submission',
                'value' => '0',
            ),
            12 => 
            array (
                'id' => 13,
                'key' => 'allow_stop_auto_migration_A',
                'value' => '0',
            ),
            13 => 
            array (
                'id' => 14,
                'key' => 'allow_stop_auto_migration_B',
                'value' => '0',
            ),
            14 => 
            array (
                'id' => 15,
                'key' => 'allow_stop_auto_migration_C',
                'value' => '0',
            ),
            15 => 
            array (
                'id' => 16,
                'key' => 'allow_opt_out_C',
                'value' => '0',
            ),
            16 => 
            array (
                'id' => 17,
                'key' => 'allow_admit_download',
                'value' => '0',
            ),
            17 => 
            array (
                'id' => 18,
                'key' => 'sms_credit',
                'value' => '11509.502',
            ),
            18 => 
            array (
                'id' => 20,
                'key' => 'allow_complaint_submission',
                'value' => '1',
            ),
            19 => 
            array (
                'id' => 21,
                'key' => 'allow_selfie_change',
                'value' => '1',
            ),
            20 => 
            array (
                'id' => 22,
                'key' => 'allow_control_room_user_login',
                'value' => '0',
            ),
            21 => 
            array (
                'id' => 23,
                'key' => 'photo_capture_test_mode',
                'value' => '1',
            ),
            22 => 
            array (
                'id' => 24,
                'key' => 'show_results',
                'value' => '0',
            ),
            23 => 
            array (
                'id' => 25,
                'key' => 'show_results_for',
                'value' => 'A, B, C',
            ),
        ));
        
        
    }
}