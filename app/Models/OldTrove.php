<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class OldTrove extends Model
{

    use SoftDeletes;

    protected $connection = 'mysql_old_troves';
    protected $table = 'troves';

    protected $casts = [
        'title' => 'collection',
        'description' => 'collection',
        'elements_urls' => 'collection',
        'elements_videos' => 'collection',
    ];

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(OldTag::class, 'taggables', 'taggable_id', 'tag_id');
    }
}
