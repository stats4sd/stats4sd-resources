<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OldTrove extends Model
{
    protected $connection = 'mysql_old_troves';
    protected $table = 'troves';

    protected $casts = [
        'title' => 'collection',
        'description' => 'collection',
        'elements_urls' => 'collection',
        'elements_videos' => 'collection',
    ];

}
