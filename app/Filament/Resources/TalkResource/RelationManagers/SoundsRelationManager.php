<?php

declare(strict_types=1);

namespace App\Filament\Resources\TalkResource\RelationManagers;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\View;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\HasManyRelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;

class SoundsRelationManager extends HasManyRelationManager
{
    protected static string $relationship = 'sounds';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name'),
                //  TextInput::make('chaptering'),
                TextInput::make('section_title'),
                TextArea::make('text'),
                TextArea::make('entities'),
                Select::make('type')
                    ->options([
                        'explanation' => 'Explanation',
                        'quotation' => 'Quotation',
                    ]),
                SpatieMediaLibraryFileUpload::make('cover'),
                View::make('filament.forms.components.audio'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('section_title'),
                //  Tables\Columns\TextColumn::make('chaptering'),
                SpatieMediaLibraryImageColumn::make('cover')->conversion('thumb'),
            ])
            ->filters([
            ]);
    }
}
