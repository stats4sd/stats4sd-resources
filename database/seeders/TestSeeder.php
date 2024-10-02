<?php

namespace Database\Seeders;

use App\Models\TagType;
use App\Models\Trove;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Parallax\FilamentComments\Models\FilamentComment;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        User::factory()->create([
            'name' => 'Test Two',
            'email' => 'test2@example.com',
        ]);
    }
}
