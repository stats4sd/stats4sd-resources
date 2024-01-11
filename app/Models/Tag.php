<?php

namespace App\Models;

use Spatie\Tags\HasTags;
use Spatie\Tags\Tag as SpatieTag;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Tag extends SpatieTag
{
    use HasFactory;
    use HasTranslations;
    use HasTags;

    protected $fillable = [
        'label',
        'slug',
        'type',
    ];

    protected $casts = [
        'id' => 'integer',
        'type' => 'integer',
    ];

    public $translatable = [
        'label',
        'slug'
    ];
    
    public static function getTagClassName(): string
    {
        return Tag::class;
    }

    public function tags(): MorphToMany
    {
        return $this
            ->morphToMany(self::getTagClassName(), 'taggable', 'taggables', null, 'tag_id')
            ->orderBy('order_column');
    }

    public function troves(): MorphToMany
    {
        return $this->morphedByMany(Trove::class, 'taggable');
    }

    public function tagType(): BelongsTo
    {
        return $this->belongsTo(TagType::class, 'type');
    }
}
