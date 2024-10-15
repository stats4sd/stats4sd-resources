<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Parallax\FilamentComments\Models\Traits\HasFilamentComments;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Collection extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use HasTranslations;
    use HasFilamentComments;


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
}
