<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\TalkResource\Pages;
use App\Filament\Resources\TalkResource\RelationManagers\SoundsRelationManager;
use App\Models\Metadata;
use App\Models\Talk;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class TalkResource extends Resource
{
    protected static ?string $model = Talk::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')->required(),
                Forms\Components\Toggle::make('published'),
                Forms\Components\TextInput::make('author'),
                Forms\Components\DatePicker::make('date'),
                Forms\Components\TextInput::make('theme'),
                Forms\Components\TextInput::make('duration'),
                Forms\Components\TextInput::make('external_id'),
                FileUpload::make('sounds')
                    ->preserveFilenames()
                    ->acceptedFileTypes(['audio/mpeg'])
                    ->directory('uploaded_sounds')
                    ->multiple()
                    ->minSize(10)
                    ->maxSize(1024 * 5)
                    ->maxFiles(50)
                    ->enableOpen(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\IconColumn::make('published')->boolean(),
                // Tables\Columns\TextColumn::make('dir'),
                Tables\Columns\TextColumn::make('title'),
                // Tables\Columns\TextColumn::make('author'),
                Tables\Columns\TextColumn::make('duration'),
            ])
            ->filters([
            ]);
    }

    public static function getRelations(): array
    {
        return [
            SoundsRelationManager::class,
            // Metadata::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTalks::route('/'),
            'create' => Pages\CreateTalk::route('/create'),
            'edit' => Pages\EditTalk::route('/{record}/edit'),
        ];
    }
}
