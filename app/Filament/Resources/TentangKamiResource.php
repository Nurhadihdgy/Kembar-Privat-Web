<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TentangKamiResource\Pages;
use App\Filament\Resources\TentangKamiResource\RelationManagers;
use App\Models\TentangKami;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TentangKamiResource extends Resource
{
    protected static ?string $model = TentangKami::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    public static function form(Form $form): Form
    {
        return $form->schema([
            RichEditor::make('isi')
                ->label('Isi Tentang Kami')
                ->required(),

            FileUpload::make('gambar')
                 ->label('Gambar atau Video')
                ->acceptedFileTypes([
                        'image/jpeg',
                        'image/png',
                        'image/webp',
                        'video/mp4',
                        'video/webm',
                        'video/ogg'
                    ])
                ->directory('tentang-kami')
                ->disk('public')
                ->enableDownload()
                ->required(false),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('gambar')->label('Gambar'),
                Tables\Columns\TextColumn::make('isi')->label('Isi')->limit(30),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTentangKamis::route('/'),
            'create' => Pages\CreateTentangKami::route('/create'),
            'edit' => Pages\EditTentangKami::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return \App\Models\TentangKami::count() === 0;
    }


    public static function canDelete(Model $record): bool
    {
        return false;
    }
}
