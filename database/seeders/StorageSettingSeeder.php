<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StorageSettingSeeder extends Seeder
{
    public function run()
    {
        DB::table('storage_settings')->insert([
            'mode' => 'local',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
