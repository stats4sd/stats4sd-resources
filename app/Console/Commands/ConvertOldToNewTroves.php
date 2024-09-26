<?php

namespace App\Console\Commands;

use App\Models\OldTrove;
use App\Models\Trove;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ConvertOldToNewTroves extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:convert-troves';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Processes the old troves and converts them to the new trove format';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $oldTroves = OldTrove::all();

        $this->info("Found {$oldTroves->count()} old troves...");

        $oldTroves->each(function (OldTrove $oldTrove) {

            // check if this trove has translated versions
            $translatedTroveIds = $this->getTranslatedTroveIds();

            $translatedTroveIdsEn = array_column($translatedTroveIds, 'en');
            $translatedTroveIdsEs = array_column($translatedTroveIds, 'es');
            $translatedTroveIdsFr = array_column($translatedTroveIds, 'fr');

            // ignore items with a newer version
            if($oldTrove->new_version_id) {
                $this->info("This trove {$oldTrove->id} has a newer version; skipping");
                return;
            }

            // ingore es and fr versions - we will add them in when we handle the en version
            if(in_array($oldTrove->id, $translatedTroveIdsEs) || in_array($oldTrove->id, $translatedTroveIdsFr)) {
                $this->info("This trove {$oldTrove->id} is a translated version of a different trove; skipping");
                return;
            }

            $spanishOldTrove = null;
            $frenchOldTrove = null;

            if(in_array($oldTrove->id, $translatedTroveIdsEn)) {
                $this->info("This trove {$oldTrove->id} has translated versions...");

                $spanishOldTroveId = $translatedTroveIds['en' . $oldTrove->id]['es'];
                $spanishOldTrove = OldTrove::find($spanishOldTroveId);

                $frenchOldTroveId = $translatedTroveIds['en' . $oldTrove->id]['fr'];
                $frenchOldTrove = OldTrove::find($frenchOldTroveId);

            }

            $this->info($oldTrove->id);
            $this->info($oldTrove->title['en']);

            $newTrove = new Trove();

            $newTrove->id = $oldTrove->id; // important to maintain relationships
            $newTrove->setTranslation('title', 'en', $oldTrove->title['en']);
            $newTrove->setTranslation('description', 'en', $oldTrove->description['en']);
            $newTrove->source = $oldTrove->source;
            $newTrove->creation_date = $oldTrove->creation_date ?? Str::of($oldTrove->slug)->after('_')->before('_');
            $newTrove->uploader_id = $oldTrove->uploader_id; // make sure the user IDs are the same...


            $externalLinks = $this->getExternalLinks($oldTrove);

            $newTrove->setTranslation('external_links', 'en', $externalLinks);

            $youtubeLinks = collect(['youtube_id' => $oldTrove->video_id]);
            $newTrove->setTranslation('youtube_links', 'en', $youtubeLinks);

            $newTrove->download_count = $oldTrove->download_count;
            $newTrove->published_at = $oldTrove->published_at;
            $newTrove->is_current = true;
            $newTrove->publisher_type = 'App\Models\User';
            $newTrove->publisher_id = 1;
            $newTrove->created_at = $oldTrove->created_at;
            $newTrove->updated_at = $oldTrove->updated_at;
            $newTrove->deleted_at = $oldTrove->deleted_at;

            // check for spanish and french version
            if($spanishOldTrove) {
                $newTrove->setTranslation('title', 'es', $spanishOldTrove->title['en']);
                $newTrove->setTranslation('description', 'es', $spanishOldTrove->description['en']);
                $newTrove->setTranslation('external_links', 'es', $this->getExternalLinks($spanishOldTrove));
                $newTrove->setTranslation('youtube_links', 'es', collect(['youtube_id' => $spanishOldTrove->video_id]));

                // move any files to the new trove
                $media = Media::where('model_type', Trove::class)->where('model_id', $spanishOldTrove->id)->get();

                $this->comment('Moving ' . $media->count() . ' media items from trove ' . $spanishOldTrove->id . ' to ' . $newTrove->id);

                $media->each(function(Media $media) use ($newTrove) {
                    $media->model_id = $newTrove->id;
                    $media->collection_name = $media->collection_name === 'coverImage' ? 'cover_image_es' : 'content_es';
                    $media->saveQuietly();
                });

            }

            if($frenchOldTrove) {
                $newTrove->setTranslation('title', 'fr', $frenchOldTrove->title['en']);
                $newTrove->setTranslation('description', 'fr', $frenchOldTrove->description['en']);
                $newTrove->setTranslation('external_links', 'fr', $this->getExternalLinks($frenchOldTrove));
                $newTrove->setTranslation('youtube_links', 'fr', collect(['youtube_id' => $frenchOldTrove->video_id]));

                // move any files to the new trove
                $media = Media::where('model_type', Trove::class)->where('model_id', $frenchOldTrove->id)->get();

                $this->comment('Moving ' . $media->count() . ' media items from trove ' . $frenchOldTrove->id . ' to ' . $newTrove->id);

                $media->each(function(Media $media) use ($newTrove) {
                    $media->model_id = $newTrove->id;
                    $media->collection_name = $media->collection_name === 'coverImage' ? 'cover_image_fr' : 'content_fr';
                    $media->saveQuietly();
                });

            }

            $newTrove->save();


            // handle media relation

            // handle tags relation


        });
    }


    public function getTranslatedTroveIds()
    {
        return [
            'en585' => ['en' => 585, 'es' => 586, 'fr' => 587],
            'en583' => ['en' => 583, 'es' => 584, 'fr' => 581],
            'en370' => ['en' => 370, 'es' => 564, 'fr' => null],
            'en557' => ['en' => 557, 'es' => null, 'fr' => 558],
            'en548' => ['en' => 548, 'es' => 528, 'fr' => null],
            'en520' => ['en' => 520, 'es' => 521, 'fr' => null],
            'en466' => ['en' => 466, 'es' => null, 'fr' => 467],
            'en450' => ['en' => 450, 'es' => 459, 'fr' => null],
            'en451' => ['en' => 451, 'es' => 438, 'fr' => null],
            'en427' => ['en' => 427, 'es' => 426, 'fr' => null],
            'en418' => ['en' => 418, 'es' => 419, 'fr' => null],
            'en367' => ['en' => 367, 'es' => 131, 'fr' => null],
            'en669' => ['en' => 669, 'es' => 670, 'fr' => 671],
            'en666' => ['en' => 666, 'es' => 668, 'fr' => 667],
            'en664' => ['en' => 664, 'es' => 665, 'fr' => null],
            'en650' => ['en' => 650, 'es' => 654, 'fr' => null],
            'en651' => ['en' => 651, 'es' => 655, 'fr' => null],
            'en652' => ['en' => 652, 'es' => 656, 'fr' => null],
            'en653' => ['en' => 653, 'es' => 657, 'fr' => null],
            'en628' => ['en' => 628, 'es' => 631, 'fr' => 632],
            'en625' => ['en' => 625, 'es' => 627, 'fr' => 626],
            'en623' => ['en' => 623, 'es' => 622, 'fr' => 624],
            'en608' => ['en' => 608, 'es' => 609, 'fr' => 610],
            'en604' => ['en' => 604, 'es' => 607, 'fr' => 605],
            'en663' => ['en' => 663, 'es' => 603, 'fr' => 602],
            'en593' => ['en' => 593, 'es' => 594, 'fr' => 595],
        ];
    }

    function getExternalLinks(OldTrove $oldTrove): \Illuminate\Support\Collection|array
    {
        $externalLinks = [];
        if ($oldTrove->elements_urls['en']) {
            $externalLinks = collect($oldTrove->elements_urls['en'])
                ->mapWithKeys(function ($item) {
                    return [
                        'link_url' => $item['path'],
                        'link_title' => $item['title'] ?? $item['path'],
                    ];
                });
        }
        return $externalLinks;
    }
}
