<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class TagType extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $fillable = [
        'label',
        'description',
        'freetext',
    ];

    protected $casts = [
        'id' => 'integer',
        'freetext' => 'boolean',
    ];

    public $translatable = [
        'label',
        'description'
    ];

    public function tags(): HasMany
    {
        return $this->hasMany(Tag::class);
    }
}
