<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TroveType extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $fillable = [
        'label',
    ];

    protected $casts = [
        'id' => 'integer',
    ];

    public $translatable = ['label'];

    public function troves(): HasMany
    {
        return $this->hasMany(Trove::class);
    }
}
