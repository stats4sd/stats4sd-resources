<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\Prep\TagSeeder;
use Database\Seeders\Prep\TagTypeSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //$this->call(RolesAndPermissionsSeeder::class);
        $this->call(TestSeeder::class);
        $this->call(TagTypeSeeder::class);
        $this->call(TagSeeder::class);
    }
}
