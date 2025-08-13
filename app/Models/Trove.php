<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;
use Oddvalue\LaravelDrafts\Concerns\HasDrafts;
use Parallax\FilamentComments\Models\Traits\HasFilamentComments;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\MediaStream;
use Spatie\Translatable\HasTranslations;

class Trove extends Model implements HasMedia
{
    use HasDrafts;
    use HasFactory;
    use HasFilamentComments;
    use HasTranslations;
    use InteractsWithMedia;
    use Searchable;
    use SoftDeletes;

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
        'troveTypes',
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

        static::saving(function (Trove $trove) {

            // don't generate a slug if it already exists
            if ($trove->slug) {
                return;
            }

            // set the slug to the first available title locale
            $locales = $trove->getTranslatedLocales('title');

            $trove->slug = Str::slug($trove->getTranslation('title', $locales[0])).'-'.Carbon::now()->format('Y-m-d');

            // check for uniqueness and append a number if necessary
            $uniquenessQuery = Trove::withTrashed()
                ->withDrafts()
                ->where('slug', $trove->slug);

            if ($trove->id) {
                $uniquenessQuery = $uniquenessQuery->where('id', '!=', $trove->id);
            }

            $count = $uniquenessQuery->count();

            if ($count > 0) {
                $trove->slug = $trove->slug.'-'.$count;
            }

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

    public function registerMediaConversions(?Media $media = null): void
    {
        $collections = [];
        foreach (config('app.locales') as $key => $locale) {
            $collections[] = "cover_image_{$key}";
        }

        $this->addMediaConversion('cover_thumb')
            ->width(450)
            ->performOnCollections(...$collections);

    }

    protected function coverImage(): Attribute
    {
        return new Attribute(
            get: fn () => $this->getFirstMediaUrl('cover_image_'.app()->getLocale()) ?? asset('images/default-cover-photo.jpg')
        );
    }

    protected function coverImageThumb(): Attribute
    {
        return new Attribute(
            get: fn() => $this->getFirstMediaUrl('cover_image_'.app()->getLocale(), 'cover_thumb') ?? asset('images/default-cover-photo.jpg')
        );
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

    public function troveTypes(): BelongsToMany
    {
        return $this->belongsToMany(TroveType::class);
    }

    public function collections(): BelongsToMany
    {
        return $this->belongsToMany(Collection::class)
            ->withPivot('id');
    }

    public function relatedTroves()
    {
        // Using the collections to get related troves
        return Trove::whereHas('collections', function ($query) {
            $query->whereIn('collections.id', $this->collections->pluck('id'));
        })
            ->where('id', '!=', $this->id)  // Exclude itself
            ->get();
    }

    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function hasPublishedVersion(): Attribute
    {
        return new Attribute(
            get: fn () => $this->revisions()->where('is_published', true)->exists()
        );
    }

    // Matching the old Algolia serachable array as much as possible
    public function toSearchableArray(): array
    {
        // title and description
        $array = $this->toArray();

        unset($array['media']);

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
            $array[strtolower($tagType->label)] = $this->tags->where('type_id', $tagType->id)->map(fn ($tag) => [
                'name' => [
                    'en' => $tag->getTranslation('name', 'en'),
                    'es' => $tag->getTranslation('name', 'es'),
                    'fr' => $tag->getTranslation('name', 'fr'),
                ],
            ])->values()->toArray();
        }

        $array['resourceTypes'] = $this->troveTypes
            ->map(fn (TroveType $type) => [
                'name' => [
                    'en' => $type->getTranslation('label', 'en'),
                    'es' => $type->getTranslation('label', 'es'),
                    'fr' => $type->getTranslation('label', 'fr'),
                ],
            ])->values()->toArray();

        $array['collections']['id'] = $this->collections->pluck('id');
        $array['tags'] = $this->tags->map(fn ($tag) => [
            'name' => [
                'en' => $tag->getTranslation('name', 'en'),
                'es' => $tag->getTranslation('name', 'es'),
                'fr' => $tag->getTranslation('name', 'fr'),
            ],
        ])->values()->toArray();

        $array['cover_image'] = $this->getFirstMediaUrl('cover_image_en');

        return $array;
    }

    public function themeAndTopicTags(): MorphToMany
    {
        return $this->tags()->whereHas('tagType', function ($query) {
            $query->whereIn('slug', ['themes', 'topics']);
        });
    }

    public function downloadAllFilesAsZip()
    {
        // Get the current app locale
        $locale = app()->getLocale();

        // Get the media collection name
        $collectionName = 'content_'.$locale;

        // Get all media files for this locale
        $troveFiles = $this->getMedia($collectionName);

        // Check if there are any files
        if ($troveFiles->isEmpty()) {
            return redirect()->back()->with('error', __('No downloadable files are available.'));
        }

        // Return the ZIP of all files
        $filename = Str::slug($this->title)."-{$locale}-files.zip";

        return MediaStream::create($filename)->addMedia($troveFiles);
    }

    public static function findBySlugOrRedirect($troveKey): ?self
    {
        // Try slug
        $trove = self::where('slug', $troveKey)
            ->where('is_published', 1)
            ->first();
        if ($trove) {
            return $trove;
        }

        // Try id
        if (is_numeric($troveKey)) {
            $trove = self::where('id', (int) $troveKey)
                ->where('is_published', 1)
                ->first();
            if ($trove) {
                return $trove;
            }
        }

        // Try previous_slugs (string)
        $trove = self::whereJsonContains('previous_slugs', (string) $troveKey)
            ->where('is_published', 1)
            ->first();
        if ($trove) {
            return $trove;
        }

        // Try previous_slugs (numeric)
        if (is_numeric($troveKey)) {
            $trove = self::whereJsonContains('previous_slugs', (int) $troveKey)
                ->where('is_published', 1)
                ->first();
            if ($trove) {
                return $trove;
            }
        }

        return null;
    }
}
