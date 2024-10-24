<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Setting::factory()->create([
        //     'telegram_token' => env('TELEGRAM_BOT_TOKEN')
        // ]);
        Setting::create([
            'name' => 'telegram_token',
            'value' => env('TELEGRAM_BOT_TOKEN'),
        ]);
        Setting::create([
            'name' => 'telegram_group_id',
            'value' => env('TELEGRAM_GROUP_ID'),
        ]);
    }
}
