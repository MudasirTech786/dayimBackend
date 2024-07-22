<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\PermissionTableSeeder;
use Database\Seeders\UserAndRoleSeeder;
use Database\Seeders\DM_eventsTableSeeder;
use Database\Seeders\DSA_eventsTableSeeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionTableSeeder::class,
            UserAndRoleSeeder::class,
            DM_eventsTableSeeder::class,
            DSA_eventsTableSeeder::class,
        ]);
    }
}
