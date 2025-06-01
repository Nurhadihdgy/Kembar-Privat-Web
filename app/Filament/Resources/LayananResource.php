<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LayananResource\Pages;
use App\Filament\Resources\LayananResource\RelationManagers;
use App\Models\Layanan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\TextInput; // Contoh untuk form
use Filament\Forms\Components\FileUpload; // Contoh untuk form
use Filament\Forms\Components\Select; // Contoh untuk form\
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\TernaryFilter;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LayananResource extends Resource
{
    protected static ?string $model = Layanan::class;

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Tambahkan field form Anda di sini
                TextInput::make('nama')
                    ->required()
                    ->maxLength(255),
                TextInput::make('slug')
                    ->disabled()
                    ->dehydrated()
                    ->label('Slug (Otomatis)')
                    ->helperText('Diambil otomatis dari nama'),
                FileUpload::make('gambar')
                    ->image()
                    ->directory('layanans') // Simpan di storage/app/public/layanans
                    ->required(),
                TextInput::make('harga')
                    ->required()
                    ->numeric()
                    ->prefix('Rp'),
                Select::make('label')
                    ->options([
                        'Populer' => 'Populer',
                        'Baru' => 'Baru',
                        'Rekomendasi' => 'Rekomendasi',
                        'Promo' => 'Promo',
                    ]),
                Forms\Components\Textarea::make('deskripsi') // Contoh field lain
                    ->columnSpanFull(),
                Toggle::make('is_active')
                    ->label('Aktifkan Layanan')
                    ->default(true)
                    ->inline(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('gambar')->square(), // Gunakan square() atau circular()
                TextColumn::make('nama')->searchable()->sortable(),
                TextColumn::make('harga')
                    ->sortable()
                    ->money('IDR') // Format sebagai mata uang
                    ->alignRight(), // Rata kanan untuk angka
                TextColumn::make('label')
                    ->badge() // Tampilkan sebagai badge
                    ->color(fn(string $state): string => match ($state) { // Beri warna beda
                        'Populer' => 'success',
                        'Baru' => 'info',
                        'Promo' => 'warning',
                        default => 'gray',
                    }),
                IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
            ])
            ->defaultSort('created_at', 'desc') // <-- PINDAHKAN KE DALAM CHAIN
            ->filters([
                // Filter bisa ditambahkan di sini
                Tables\Filters\SelectFilter::make('label')
                    ->options([
                        'populer' => 'Populer',
                        'baru' => 'Baru',
                        'promo' => 'Promo',
                    ]),
                TernaryFilter::make('is_active')
                    ->label('Status Aktif')
                    ->trueLabel('Aktif')
                    ->falseLabel('Tidak Aktif')
                    ->placeholder('Semua'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(), // Tambah View Action
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(), // Tambah Delete Action
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
            'index' => Pages\ListLayanans::route('/'),
            'create' => Pages\CreateLayanan::route('/create'),
            'edit' => Pages\EditLayanan::route('/{record}/edit'),
        ];
    }
}
