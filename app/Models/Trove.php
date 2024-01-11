<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Tags\HasTags;
use Spatie\Translatable\HasTranslations;

class Trove extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use HasTags;
    use HasTranslations;

    protected $fillable = [
        'title',
        'description',
        'uploader_id',
        'creation_date',
        'trove_type_id',
        'public',
        'external_links',
        'youtube_links',
        'source',
        'download_count',
    ];

    protected $casts = [
        'id' => 'integer',
        'uploader_id' => 'integer',
        'creation_date' => 'date',
        'trove_type_id' => 'integer',
        'public' => 'boolean',
        'source' => 'boolean',
        'external_links' => 'array',
        'youtube_links' => 'array'
    ];

    public $translatable = [
        'title',
        'description',
        'external_links',
        'youtube_links'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploader_id');
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function troveType(): BelongsTo
    {
        return $this->belongsTo(TroveType::class);
    }

    public function collections(): BelongsToMany
    {
        return $this->belongsToMany(Collection::class);
    }
}
