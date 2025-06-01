<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AnggotaResource\Pages;
use App\Filament\Resources\AnggotaResource\RelationManagers;
use App\Models\Anggota;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
// use Filament\Tables\Columns\BooleanColumn; // Tidak digunakan di sini, bisa dihapus jika hanya untuk ini
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\BooleanFilter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\ToggleFilter; // Import untuk ToggleFilter
use Filament\Tables\Filters\TernaryFilter; // Import untuk TernaryFilter
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\ImageColumn;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AnggotaResource extends Resource
{
    protected static ?string $model = Anggota::class;

    protected static ?string $navigationIcon = 'heroicon-o-users'; // Mengganti ikon agar lebih relevan

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama')->required()->maxLength(255)->columnSpanFull(),
                FileUpload::make('foto')
                    ->label('Foto Profil')
                    ->image()
                    ->imageEditor()
                    ->directory('foto-anggota')
                    ->imagePreviewHeight('150')
                    ->columnSpanFull(),
                Select::make('jenis_kelamin')
                    ->options([
                        'L' => 'Laki-laki',
                        'P' => 'Perempuan',
                    ])
                    ->required(),
                TextInput::make('telepon')
                    ->tel() // Gunakan tipe tel untuk validasi
                    ->required()
                    ->maxLength(20),
                Textarea::make('profil')->rows(4)->columnSpanFull(),
                Select::make('tipe')
                    ->options([
                        'pengajar' => 'Pengajar',
                        'staff' => 'Staff',
                    ])
                    ->required(),
                Toggle::make('is_active')
                    ->label('Aktifkan Anggota')
                    ->inline(false) // Agar label di atas toggle
                    ->default(true),
            ])->columns(2); // Mengatur form menjadi 2 kolom
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('nama')->sortable()->searchable(),
            ImageColumn::make('foto')
                ->label('Foto')
                ->circular()
                ->size(50)
                ->defaultImageUrl(url('/images/default-profile.png')),
            TextColumn::make('jenis_kelamin')
                ->label('Jenis Kelamin')
                ->badge()
                ->color(fn($state): string => match ($state) {
                    'L' => 'info', // Mengganti warna agar lebih kontras
                    'P' => 'pink',
                    default => 'gray',
                })
                ->formatStateUsing(fn($state): string => match ($state) {
                    'L' => 'Laki-laki',
                    'P' => 'Perempuan',
                    default => '-',
                }),

            TextColumn::make('telepon')->label('Telepon')->searchable(),
            TextColumn::make('tipe')
                ->label('Tipe')
                ->badge()
                ->color(fn($state): string => match ($state) {
                    'pengajar' => 'primary', // Menggunakan warna primary Filament
                    'staff' => 'success',
                    default => 'gray',
                })
                ->formatStateUsing(fn($state): string => match ($state) {
                    'pengajar' => 'Pengajar',
                    'staff' => 'Staff',
                    default => '-',
                }),

            IconColumn::make('is_active')
                ->label('Status Aktif')
                ->boolean() // Ini benar untuk menampilkan boolean sebagai ikon di kolom
                ->trueIcon('heroicon-o-check-circle')
                ->falseIcon('heroicon-o-x-circle')
                ->trueColor('success')
                ->falseColor('danger'),
        ])
            ->filters([
                SelectFilter::make('tipe')
                    ->options([
                        'pengajar' => 'Pengajar',
                        'staff' => 'Staff',
                    ])
                    ->label('Filter berdasarkan Tipe'),
                TernaryFilter::make('is_active')
                    ->label('Filter Status Aktif')
                    ->trueLabel('Aktif')
                    ->falseLabel('Tidak Aktif')
                    ->placeholder('Semua Status'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListAnggotas::route('/'),
            'create' => Pages\CreateAnggota::route('/create'),
            'edit' => Pages\EditAnggota::route('/{record}/edit'),
        ];
    }
}
