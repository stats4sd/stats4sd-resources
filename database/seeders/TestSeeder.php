<?php

namespace Database\Seeders;

use App\Models\TagType;
use App\Models\Trove;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = DB::connection('mysql_old_troves')
            ->table('users')
            ->select('id', 'name', 'email', 'password')
            ->get();

        foreach ($users as $user) {
            if ($user->id > 0) {

                User::create([
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'password' => $user->password ?? bcrypt('password'),
                ]);
            }
        }

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        User::factory()->create([
            'name' => 'Test Two',
            'email' => 'test2@example.com',
        ]);

        // Handle Media table
        $uuids = collect([]);

        $mediaItems = DB::connection('mysql_old_troves')
            ->table('media')
            ->get();

        foreach ($mediaItems as $item) {

            $itemArray = [];
            foreach ($item as $key => $value) {

                // preserve arrays
                if (is_string($value) && (str_starts_with($value, '[') || str_starts_with($value, '{'))) {
                    $itemArray[$key] = json_decode($value, true);
                    continue;
                }

                $itemArray[$key] = $value;
            }

            //rename collections to match new structure
            if ($itemArray['model_type'] === Trove::class) {

                $itemArray['collection_name'] = match ($itemArray['collection_name']) {
                    'coverImage' => 'trove_cover',
                    'troveFiles' => 'content_en',
                    default => $itemArray['collection_name'],
                };
            }

            // if the uuid is identical, we can overwrite the old one
            if ($uuids->contains($itemArray['uuid'])) {
                Media::firstWhere('uuid', $itemArray['uuid'])->updateQuietly($itemArray);
            } else {
                Media::create($itemArray);
            }

            $uuids[] = $itemArray['uuid'];

        };

    }
}
