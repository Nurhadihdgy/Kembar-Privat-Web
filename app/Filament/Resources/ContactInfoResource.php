<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactInfoResource\Pages;
use App\Filament\Resources\ContactInfoResource\RelationManagers;
use App\Models\ContactInfo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn; // <-- PASTIKAN BARIS INI ADA

class ContactInfoResource extends Resource
{
    protected static ?string $model = ContactInfo::class;

    // Saran: Ganti ikon agar lebih sesuai
    protected static ?string $navigationIcon = 'heroicon-o-phone-arrow-up-right';
    protected static ?string $navigationGroup = 'Pengaturan Situs'; // Kelompokkan

    // Mencegah pembuatan data baru jika hanya boleh ada satu
    public static function canCreate(): bool
    {
        return static::getModel()::count() === 0;
    }


    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('alamat')
                ->label('Alamat')
                ->required()
                ->columnSpanFull() // Ambil lebar penuh
                ->maxLength(255),

            TextInput::make('telepon')
                ->label('Telepon')
                ->tel() // Gunakan tipe telepon
                ->required()
                ->maxLength(20),

            TextInput::make('whatsapp')
                ->label('WhatsApp (Nomor)')
                ->required()
                ->hint('Isi nomor tanpa +, contoh: 6281234567890')
                ->maxLength(20),

            TextInput::make('email') // Tambahkan email jika perlu
                ->label('Email')
                ->email()
                ->maxLength(100),

            TextInput::make('instagram')
                ->label('Instagram Username')
                ->hint('Masukkan username tanpa @')
                ->maxLength(50),

            Textarea::make('google_maps_url')
                ->label('Google Maps URL')
                ->rows(3)
                ->placeholder('Tempelkan embed URL dari Google Maps')
                ->helperText('Salin bagian src dari iframe Google Maps Embed'),

        ])->columns(2); // Atur form menjadi 2 kolom
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('alamat')->limit(30)->wrap(), // Wrap jika panjang
                TextColumn::make('telepon'),
                TextColumn::make('whatsapp'),
                TextColumn::make('instagram'),
                TextColumn::make('email')->toggleable(isToggledHiddenByDefault: true), // Sembunyikan by default
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(), // Mungkin tidak perlu delete jika hanya 1 data
            ])
            ->bulkActions([]); // Mungkin tidak perlu bulk action
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
            'index' => Pages\ListContactInfos::route('/'),
            // 'create' => Pages\CreateContactInfo::route('/create'), // Mungkin tidak perlu create jika hanya 1 data
            'edit' => Pages\EditContactInfo::route('/{record}/edit'),
        ];
    }
}