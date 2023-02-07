<?php

namespace App\Models;

use DOMDocument;
use DOMXPath;
use Http;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Storage;

class Metadata extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function getJson(string $url)
    {
        $response = Http::get($url);
        $html = $response->body();
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($html);
        $xpath = new DOMXPath($dom);
        $jsonScripts = $xpath->query('//script[@type="application/ld+json"]');
        $json = trim($jsonScripts->item(0)->nodeValue);

        return $json;
    }

    public static function fileToCollection(string $filePath)
    {
        $decodedJson = json_decode(Storage::get($filePath), true);

        // dd($decodedJson);

        $attributes = [];
        foreach ($decodedJson as $key => $value) {
            if (is_array($value)) {
                $attributes = array_merge($attributes, self::xxxxxx($key, $value));
            } elseif (is_string($value)) {
                $attributes[] = [
                    'key' => $key,
                    'value' => $value,
                ];
            }
        }
        // dd($attributes);

        return collect($attributes);
    }

    public static function xxxxxx($key, $value)
    {
        $attributes = [];
        foreach ($value as $subkey => $value) {
            if (is_array($value)) {
                $attributes = array_merge($attributes, self::xxxxxx($key.'.'.$subkey, $value));
            } elseif (is_string($value)) {
                $attributes[] = [
                    'key' => $key.'.'.$subkey,
                    'value' => $value,
                ];
            }
        }

        return $attributes;
    }
}
