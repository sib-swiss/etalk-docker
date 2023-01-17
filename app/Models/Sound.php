<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Storage;

class Sound extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $guarded = [];

    public function talk()
    {
        return $this->belongsTo(Talk::class);
    }

    /**
     * Get file path of mp3 from storage/app/public/data
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function filepath(): Attribute
    {
        return Attribute::make(
            get: fn () => 'talks/'.$this->talk_id.'/'.$this->name,
        );
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::deleted(function ($model) {
            Storage::delete('public/'.$model->filepath);
        });
    }
}
