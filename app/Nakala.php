<?php

namespace App;

use Http;
use Storage;

class Nakala
{
    public static function getJsonFromUrl(string $url)
    {

        // https://nakala.fr/10.34847/nkl.ee3fd43r
        // https://api.nakala.fr/datas/10.34847/nkl.ee3fd43r
        $nakala_parsed_url = parse_url($url);
        $nakala_api_url = $nakala_parsed_url['scheme'].'://api.'.$nakala_parsed_url['host'].'/datas'.$nakala_parsed_url['path'];
        $response = Http::get($nakala_api_url);
        $body = $response->body();

        return json_encode(json_decode($body), JSON_PRETTY_PRINT);
    }

    public static function saveMetadata(string $url, string $storagepath)
    {
        Storage::put($storagepath.'/metadata_nakala.json', self::getJsonFromUrl($url));
    }

    public static function filetoCollection(string $filePath)
    {
        $decodedJson = json_decode(Storage::get($filePath), true);
        $collection = [];

        // dd(array_keys($decodedJson));
        foreach ($decodedJson as $key => $node) {
            if (! in_array($key, [
                'citation',
                'metas',
            ])) {
                continue;
            }

            if (is_string($node)) {
                $collection[] = [
                    'key' => $key,
                    'value' => $node,
                ];
                continue;
            }

            if (is_array($node)) {
                // logger()->debug(__LINE__, [$key]);
                $collection = array_merge($collection, self::nodeToAttributes($node));
            }
        }
        // dd($collection);

        return collect($collection);
    }

    public static function nodeToAttributes(array $node)
    {
        if (isset($node['propertyUri'])) {
            $explodedUri = explode('/', $node['propertyUri']);

            return [
                'key' => end($explodedUri),
                'value' => is_string($node['value'])
                    ? $node['value']
                    : (
                        'terms#creator' === end($explodedUri)
                        ? $node['value']['fullName']
                        : 'NA'
                    ),
                // : $node['value']

            ];
        }

        $attributes = [];
        // dd($node);
        foreach ($node as $subkey => $childNode) {
            // logger()->debug(__LINE__, [$subkey,  self::nodeToAttributes($childNode), ['ATTRIB'=>$attributes]]);

            if (is_array($childNode)) {
                // dd($attributes , self::nodeToAttributes($childNode));
                $attributes[] = self::nodeToAttributes($childNode);
            // dd($subkey,$attributes);
            } elseif (is_string($childNode)) {
                // $attributes[] = [
                //     'key' => $subkey,
                //     'value' => $childNode,
                // ];
            }
        }
        // dd($attributes);
        return $attributes;
    }
}
