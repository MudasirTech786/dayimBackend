<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\PermissionTableSeeder;
use Database\Seeders\UserAndRoleSeeder;
use Database\Seeders\MealTypesTableSeeder;
use Database\Seeders\CurrencyConversionTableSeeder;
use Database\Seeders\VisaSeeder;
use Database\Seeders\WeekendTableSeeder;
use Database\Seeders\RouteSeeder;
use Database\Seeders\TransportTypeSeeder;
use Database\Seeders\RoomSeeder;


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
            MealTypesTableSeeder::class,
            CurrencyConversionTableSeeder::class,
            VisaSeeder::class,
            WeekendTableSeeder::class,
            RouteSeeder::class,
            // TransportTypeSeeder::class,
            RoomSeeder::class,
        ]);
    }
}
