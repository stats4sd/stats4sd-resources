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
            get: fn ()  => $this->getMedia("cover_image_" . app()->getLocale())->first()?->getUrl() ?? asset('images/default-cover-photo.jpg')
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
        return [
            'title' => $this->title,
            'description' => $this->description,
        ];
    }
}
