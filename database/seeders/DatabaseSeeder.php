<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            // CompanySeeder::class,
            // SettingSeeder::class,
            // ServerSeeder::class,
            // VpnSeeder::class,
            // PortSeeder::class,
            TestMigrateSeeder::class,
            UserSeeder::class,
            // RouterSeeder::class,
            // BankSeeder::class,
        ]);
    }
}
