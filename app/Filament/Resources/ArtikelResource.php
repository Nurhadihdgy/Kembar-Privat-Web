<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArtikelResource\Pages;
use App\Filament\Resources\ArtikelResource\RelationManagers;
use App\Models\Artikel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Forms\Components\TextInput; // Contoh untuk form
use Filament\Forms\Components\FileUpload; // Contoh untuk form
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TagsColumn;
use Filament\Forms\Components\MultiSelect;

class ArtikelResource extends Resource
{
    protected static ?string $model = Artikel::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('judul')
                    ->required()
                    ->maxLength(255),

                RichEditor::make('isi')
                    ->required(),

                FileUpload::make('gambar')
                    ->image()
                    ->directory('artikel'),

                Select::make('kategori_artikel_id')
                    ->label('Kategori')
                    ->relationship('kategori', 'nama')
                    ->preload() // preload data, tidak perlu pencarian
                    ->required(),

                Select::make('user_id')
                    ->label('Penulis')
                    ->relationship('penulis', 'name')
                    ->preload(),

                Select::make('tags')
                    ->label('Tags')
                    ->relationship('tags', 'nama')
                    ->preload()
                    ->multiple() // <-- TAMBAHKAN INI
                    ->searchable(),

                DateTimePicker::make('published_at')
                    ->label('Waktu Publikasi')
                    ->default(now()) // Menggunakan waktu saat ini sesuai timezone default aplikasi
                    ->seconds(false) // Opsional: menyembunyikan input detik
                    ->displayFormat('d/m/Y H:i') // Opsional: format tampilan
                    ->timezone('Asia/Jakarta'), // 
                 Toggle::make('is_published')
                            ->label('Publikasikan Artikel')
                            ->default(true)
                            ->inline(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('judul')
                    ->label('Judul')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('kategori.nama')
                    ->label('Kategori')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('penulis.name')
                    ->label('Penulis')
                    ->sortable()
                    ->searchable(),

                TagsColumn::make('tags.nama')
                    ->label('Tags')
                    ->separator(','),

                TextColumn::make('published_at')
                    ->label('Tanggal Publikasi')
                    ->date('d M Y')
                    ->sortable(),
                IconColumn::make('is_published')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                
            ])
            ->filters([
                TernaryFilter::make('is_published')
                    ->label('Status Publikasi')
                    ->trueLabel('Sudah Dipublikasikan')
                    ->falseLabel('Belum Dipublikasikan')
                    ->placeholder('Semua'),
                Tables\Filters\SelectFilter::make('kategori_artikel_id')
                    ->relationship('kategori', 'nama')
                    ->label('Kategori'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(), // Tambah View Action
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListArtikels::route('/'),
            'create' => Pages\CreateArtikel::route('/create'),
            'edit' => Pages\EditArtikel::route('/{record}/edit'),
        ];
    }
}
