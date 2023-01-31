<?php

namespace App\Filament\Resources\TalkResource\Pages;

use App\Filament\Resources\TalkResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Storage;

class EditTalk extends EditRecord
{
    protected static string $resource = TalkResource::class;

    protected function handleRecordUpdate(Model $talk, array $data): Model
    {
        $sounds = $data['sounds'];
        unset($data['sounds']);

        $reSeedMetadata = $talk->external_id !== $data['external_id'];

        $talk->update($data);
        if ($reSeedMetadata) {
            $talk->saveMetadata();
            $talk->seedMetadata();
        }

        foreach ($sounds as $sound) {
            $name = str_replace('uploaded_sounds/', '', $sound);
            Storage::move('public/'.$sound, "{$talk->storagepath}/".$name);
            $talk->sounds()->create([
                'name' => $name,
                'text' => '',
                'entities' => '',
                'file' => '',
                'type' => 'explanation',
            ]);
        }

        return $talk;
    }
}
