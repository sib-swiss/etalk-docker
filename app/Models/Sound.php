<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sound extends Model
{
    use HasFactory;
    public $incrementing = false;

    public function mytalk()
    {
        return $this->belongsTo(Talk::class, 'dir', 'dir');
    }
}
