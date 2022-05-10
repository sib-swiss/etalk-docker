<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Sound extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    public function talk()
    {
        return $this->belongsTo(Talk::class);
    }
}
