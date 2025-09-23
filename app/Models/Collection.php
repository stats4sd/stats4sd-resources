<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Laravel\Scout\Searchable;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Parallax\FilamentComments\Models\Traits\HasFilamentComments;

class Collection extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use HasTranslations;
    use HasFilamentComments;
    use Searchable;

    protected $casts = [
        'public' => 'boolean',
    ];

    public array $translatable = [
        'title',
        'description',
    ];

    public function registerMediaCollections(): void
    {
        foreach (config('app.locales') as $key => $locale) {
            $this->addMediaCollection("cover_image_{$key}")
                ->singleFile();
        }

    }

    protected function coverImage(): Attribute
    {
        return new Attribute(
            get: fn() => $this->getFirstMediaUrl('cover_image_' . app()->getLocale()) ?? asset('images/default-cover-photo.jpg')
        );
    }

    protected function coverImageThumb(): Attribute
    {
        return new Attribute(
            get: function () {
                $currentLocale = app()->getLocale();

                // 1. Check current locale
                $url = $this->getFirstMediaUrl('cover_image_'.$currentLocale, 'cover_thumb');
                if ($url) {
                    return $url;
                }

                // 2. Fallback to English
                if ($currentLocale !== 'en') {
                    $url = $this->getFirstMediaUrl('cover_image_en', 'cover_thumb');
                    if ($url) {
                        return $url;
                    }
                }

                // 3. Fallback to the other locale
                $otherLocale = collect(['es', 'fr'])
                    ->first(fn($locale) => $locale !== $currentLocale);

                if ($otherLocale) {
                    $url = $this->getFirstMediaUrl('cover_image_'.$otherLocale, 'cover_thumb');
                    if ($url) {
                        return $url;
                    }
                }

            }
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

    public function troves(): BelongsToMany
    {
        return $this->belongsToMany(Trove::class)
            ->withPivot('id');
    }

    public function relatedCollections()
    {
        return Collection::whereHas('troves', function ($query) {
            $query->whereIn('collection_trove.trove_id', $this->troves->pluck('id'));
        })
            ->where('id', '!=', $this->id) // Exclude itself
            ->distinct()
            ->get();
    }


    public function toSearchableArray(): array
    {
        $titles = [];
        $descriptions = [];

        foreach (config('app.locales') as $locale => $label) {
            $title = $this->getTranslation('title', $locale);
            $description = $this->getTranslation('description', $locale);

            // Only add unique, non-empty titles/descriptions
            if ($title && !in_array($title, $titles)) {
                $titles[] = $title;
            }

            if ($description) {
                $description = strip_tags($description);
                if (!in_array($description, $descriptions)) {
                    $descriptions[] = $description;
                }
            }
        }

        return [
            'title' => implode(' ', $titles),
            'description' => implode(' ', $descriptions),
            'id' => $this->id,
            'public' => (int) $this->public,
        ];
    }
}
