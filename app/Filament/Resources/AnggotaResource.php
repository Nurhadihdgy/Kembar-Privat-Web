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
// use Filament\Forms\Components\Textarea; // Diganti dengan RichEditor
use Filament\Forms\Components\RichEditor; // <-- DITAMBAHKAN: Import untuk RichEditor
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\BooleanFilter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\ToggleFilter;
use Filament\Tables\Filters\TernaryFilter;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AnggotaResource extends Resource
{
    protected static ?string $model = Anggota::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('foto')
                    ->label('Foto Profil')
                    ->image()
                    ->imageEditor()
                    ->directory('anggota-fotos') // Folder penyimpanan di storage/app/public/
                    ->imagePreviewHeight('150')
                    ->nullable()
                    ->columnSpanFull(),
                TextInput::make('nama')->required()->maxLength(255)->columnSpanFull(),
                Select::make('jenis_kelamin')
                    ->options([
                        'L' => 'Laki-laki',
                        'P' => 'Perempuan',
                    ])
                    ->required(),
                TextInput::make('telepon')
                    ->tel()
                    ->required()
                    ->maxLength(20),
                RichEditor::make('profil') // <-- DIUBAH dari Textarea ke RichEditor
                    ->label('Profil Anggota')
                    ->columnSpanFull()
                    ->fileAttachmentsDisk('public') // Tentukan disk penyimpanan
                    ->fileAttachmentsDirectory('anggota-profil-attachments') // Folder untuk attachment
                    ->fileAttachmentsVisibility('public') // Visibilitas file
                    ->toolbarButtons([ // Opsional: kustomisasi tombol toolbar
                        'attachFiles',
                        'blockquote',
                        'bold',
                        'bulletList',
                        'codeBlock',
                        'h2',
                        'h3',
                        'italic',
                        'link',
                        'orderedList',
                        'redo',
                        'strike',
                        'undo',
                    ]),
                Select::make('tipe')
                    ->options([
                        'pengajar' => 'Pengajar',
                        'staff' => 'Staff',
                    ])
                    ->required(),
                Toggle::make('is_active')
                    ->label('Aktifkan Anggota')
                    ->inline(false)
                    ->default(true),
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            ImageColumn::make('foto')
                ->label('Foto')
                ->circular()
                ->size(60) 
                ->defaultImageUrl(url('/images/placeholder-user.png')),
            TextColumn::make('nama')->sortable()->searchable(),
            TextColumn::make('jenis_kelamin')
                ->label('Jenis Kelamin')
                ->badge()
                ->color(fn($state): string => match ($state) {
                    'L' => 'info',
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
                    'pengajar' => 'primary',
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
                ->boolean()
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
