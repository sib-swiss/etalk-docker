<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sound extends Model
{
    use HasFactory;

    public $incrementing = false;

    public function talk()
    {
        return $this->belongsTo(Talk::class);
    }
}
