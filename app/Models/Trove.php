<?php

namespace App\Models;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;
use \Oddvalue\LaravelDrafts\Concerns\HasDrafts;
use Parallax\FilamentComments\Models\Traits\HasFilamentComments;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\MediaCollections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Trove extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use HasTranslations;
    use HasDrafts;
    use HasFilamentComments;
    use Searchable;

    protected $casts = [
        'id' => 'integer',
        'uploader_id' => 'integer',
        'creation_date' => 'date',
        'trove_type_id' => 'integer',
        'source' => 'boolean',
        'external_links' => 'array',
        'youtube_links' => 'array',
        'check_requested' => 'boolean',
        'previous_slugs' => 'array',
    ];

    public array $translatable = [
        'title',
        'description',
        'external_links',
        'youtube_links',
    ];

    protected array $draftableRelations = [
        'tags',
        'troveType',
        'collections',
    ];

    protected static function booted()
    {
        // listen to custom event 'drafted'
        static::registerModelEvent('drafted', function ($trove) {

            // clone media items to the newly created draft
            $draft = $trove->revisions()->where('is_current', true)->first();

            $trove->getRegisteredMediaCollections()->each(function (MediaCollection $collection) use ($trove, $draft) {

                $trove->getMedia($collection->name)->each(function (Media $media) use ($draft) {

                    $media->copy($draft, $media->collection_name, $media->disk);
                });
            });


        });
    }

    // Media Library - explicitly register collections
    public function registerMediaCollections(): void
    {
        foreach (config('app.locales') as $key => $locale) {
            $this->addMediaCollection("cover_image_{$key}")
                ->singleFile();

            $this->addMediaCollection("content_{$key}");
        }
    }


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploader_id');
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function checker(): BelongsTo
    {
        return $this->belongsTo(User::class, 'checker_id');
    }

    public function requester(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    public function troveType(): BelongsTo
    {
        return $this->belongsTo(TroveType::class);
    }

    public function collections(): BelongsToMany
    {
        return $this->belongsToMany(Collection::class)
            ->withPivot('id');
    }

    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function hasPublishedVersion(): Attribute
    {
        return new Attribute(
            get: fn() => $this->revisions()->where('is_published', true)->exists()
        );
    }


    // Matching the old Algolia serachable array as much as possible
    public function toSearchableArray(): array
    {
        // title and description
        $array = $this->toArray();

        $languages = [];

        foreach (config('app.locales') as $locale => $label) {
            // truncate description
            if (isset($array['description'][$locale])) {
                $array['description'][$locale] = Str::of($array['description'][$locale])->limit(100)->stripTags();
            }

            // add language if exists
            if (isset($array['title'][$locale])) {
                $languages[] = $label;
            }
        }

        $array['languages']['name']['en'] = $languages;

        foreach (TagType::all() as $tagType) {
            $array[strtolower($tagType->label)] = $this->tags->where('type_id', $tagType->id)->map(fn($tag) => [
                'name' => [
                    'en' => $tag->getTranslation('name', 'en'),
                    'es' => $tag->getTranslation('name', 'es'),
                    'fr' => $tag->getTranslation('name', 'fr'),
                ],
            ])->values()->toArray();
        }


        $array['resourceTypes']['name']['en'] = $this->troveType?->label ?? '';
        $array['collections']['id'] = $this->collections->pluck('id');
        $array['tags'] = $this->tags->map(fn($tag) => [
            'name' => [
                'en' => $tag->getTranslation('name', 'en'),
                'es' => $tag->getTranslation('name', 'es'),
                'fr' => $tag->getTranslation('name', 'fr'),
            ],
        ])->values()->toArray();


        $array['cover_image'] = $this->getFirstMediaUrl('cover_image_en');

        return $array;
    }
}
