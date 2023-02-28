<?php

declare(strict_types=1);

namespace App\Models;

use App\Nakala;
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
        return $this->hasMany(Sound::class)->orderBy('name');
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
        if (! $criteria) {
            return $query;
        }

        return $query->where(function ($query) use ($criteria): void {
            $query->where('title', 'like', '%'.$criteria.'%')
                ->orWhere('author', 'like', '%'.$criteria.'%')
                ->orWhere('theme', 'like', '%'.$criteria.'%')
                ->orWhere('date', 'like', '%'.$criteria.'%');

            // search in sounds text
            $query->orWhereHas('sounds', function ($query) use ($criteria): void {
                $query->where('text', 'like', '%'.$criteria.'%');
            });

            // search in metadata
            $query->orWhereHas('metadatas', function ($query) use ($criteria) {
                if (strtolower($criteria) === 'english') {
                    $query->where(function ($query) {
                        $query->where('key', 'language')
                            ->where('value', 'en');
                    });
                } elseif (strtolower($criteria) === 'french') {
                    $query->where(function ($query) {
                        $query->where('key', 'language')
                            ->where('value', 'fr');
                    });
                } else {
                    $query->where('value', 'like', '%'.$criteria.'%');
                }
            });
        });
    }

    public function metadatas()
    {
        return $this->hasMany(Metadata::class);
    }

    public function getMetaValueByKeyword(string $keyword)
    {
        // dd([
        //     $keyword,
        //     $this->metadatas()
        //         ->where('key', 'LIKE', $keyword . "%")
        //         ->take(5)
        //         ->get()
        //         ->toArray(),
        //     $this->metadatas->pluck('key')
        // ]);
        $xxx = $this->metadatas->where('key', $keyword)->first();
        if ($xxx) {
            return $xxx->value;
        }

        return '';
    }

    public function metadatasTable()
    {
        $data = [
            'Title' => $this->getMetaValueByKeyword('terms#title'),
            'Author' => $this->getMetaValueByKeyword('terms#creator'),
            'Created' => $this->getMetaValueByKeyword('terms#created'),
            'License' => $this->getMetaValueByKeyword('terms#license'),
            // 'Type' => '', //$this->metadatas->where('key','type'),
            'Keywords' => $this->metadatas->filter(function ($item) {
                return str_starts_with($item->key, 'subject');
            })->pluck('value')->toArray(),
            'Description' => $this->getMetaValueByKeyword('description'),
            'Language' => $this->getMetaValueByKeyword('language'),
            'Http://purl.org/dc/terms/isversionof' => $this->getMetaValueByKeyword('isVersionOf'),
            'Http://purl.org/dc/terms/ispartof' => $this->getMetaValueByKeyword('isPartOf'),
            'Http://purl.org/dc/terms/provenance' => $this->getMetaValueByKeyword('provenance'),

        ];
        // foreach ($this->metadatas as $meta) {
        //     $explodedKey = explode(".", $meta->key);
        //     if (in_array($explodedKey[0], [
        //         // 'isPartOf',
        //         '@context',
        //         '@id',
        //         '@type',
        //         'hasPart'
        //     ])) {
        //         continue;
        //     }
        //     if (isset($explodedKey[1])) {
        //         if (isset($explodedKey[2])) {
        //             $data[$explodedKey[0]][$explodedKey[1]][$explodedKey[2]] = $meta->value;
        //         } else {
        //             $data[$explodedKey[0]][$explodedKey[1]] = $meta->value;
        //         }
        //     } else {
        //         $data[$explodedKey[0]] = $meta->value;
        //     }
        // }
        return $data;
    }

    public function saveMetadata()
    {
        $json = Metadata::getJson($this->external_id);

        $url = json_decode($json)->url;
        if (strpos($url, 'nakala') !== false) {
            Nakala::saveMetadata($url, $this->storagepath);
        }
        // dd($url);
        return Storage::put($this->storagepath.'/metadata.json', $json);
    }

    public function seedMetadata()
    {
        if (! $this->external_id) {
            return;
        }
        if (
            ! Storage::exists($this->storagepath.'/metadata.json')
            || (time() - Storage::lastModified($this->storagepath.'/metadata.json') > 60 * 60 * 24) //older than 1 day
        ) {
            self::saveMetadata($this->external_id);
        }

        $collection = Storage::exists($this->storagepath.'/metadata_nakala.json')
            ? Nakala::fileToCollection($this->storagepath.'/metadata_nakala.json')
            : Metadata::fileToCollection($this->storagepath.'/metadata.json');

        $metadatas = [];
        // dd($collection);
        foreach ($collection as $attributes) {
            // dd($attributes);
            // logger()->debug(__LINE__ , $attributes);
            $metadatas[] = $this->metadatas()->create($attributes);
        }
        // dd($metadatas);
        return $metadatas;
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
