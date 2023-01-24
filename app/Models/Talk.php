<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Storage;

class Talk extends Model
{
    use HasFactory;

    // public $incrementing = false;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'date:Y-m-d',
    ];

    protected $guarded = [];

    public function sounds()
    {
        return $this->hasMany(Sound::class);
    }

    protected function storagepath(): Attribute
    {
        return Attribute::make(
            get: fn () => "public/talks/{$this->id}",
        );
    }

    /**
     * Scope a query to search by criteria.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearchByCriteria($query, string|null $criteria)
    {
        return $query->where(function ($query) use ($criteria): void {
            $query->where('title', 'like', '%'.$criteria.'%');
            // search in sounds text
            $query->orWhereHas('sounds', function ($query) use ($criteria): void {
                $query->where('text', 'like', '%'.$criteria.'%');
            });
        });
    }

    public function metadatas()
    {
        return $this->hasMany(Metadata::class);
    }

    public function saveMetadata()
    {
        $json = Metadata::getJson($this->external_id);

        return Storage::put($this->storagepath.'/metadata.json', $json);
    }

    public function seedMetadata()
    {
        if (! $this->external_id) {
            return;
        }
        if (! Storage::exists($this->storagepath.'/metadata.json')) {
            self::saveMetadata($this->external_id);
        }
        $json = Storage::get($this->storagepath.'/metadata.json');
        $metadatas = [];
        $collection = Metadata::jsonToCollection($json);
        // dd($collection);
        foreach ($collection as $attributes) {
            $metadatas[] = $this->metadatas()->create($attributes);
        }

        return $metadatas;
    }

    /**
     * Scope a query to search a term.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  Sting  $term
     * @return void
     */
    public function scopeSearch($query, string $term)
    {
        return $query->where('title', 'like', '%'.$term.'%')
            ->orWhere('author', 'like', '%'.$term.'%')
            ->orWhere('theme', 'like', '%'.$term.'%')
            ->orWhere('date', 'like', '%'.$term.'%')
            ->orWhereHas('metadatas', function ($query) use ($term) {
                $query->where('value', 'like', '%'.$term.'%');
            });
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::created(function ($model) {
            Storage::makeDirectory($model->storagepath);
            chmod(storage_path('app/'.$model->storagepath), 0777);
        });

        static::deleted(function ($model) {
            $model->sounds->each->delete();
        });
    }
}
