<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select; // Import Select
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash; // Untuk password

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Manajemen Pengguna'; // Grouping menu di sidebar

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->email()
                    ->unique(ignoreRecord: true) // Pastikan unik kecuali saat mengedit record yang sama
                    ->required()
                    ->maxLength(255),
                TextInput::make('password')
                    ->password()
                    ->dehydrateStateUsing(fn (string $state): string => Hash::make($state)) // Enkripsi password saat disimpan
                    ->dehydrated(fn (?string $state): bool => filled($state)) // Hanya proses jika password diisi
                    ->required(fn (string $operation): bool => $operation === 'create'), // Wajib saat membuat, opsional saat edit
                Select::make('role')
                    ->options([
                        'admin' => 'Admin',
                        'pegawai' => 'Pegawai',
                    ])
                    ->required()
                    ->default('pegawai'),
                TextInput::make('nip')
                    ->unique(ignoreRecord: true)
                    ->maxLength(20)
                    ->nullable(), // NIP bisa kosong untuk Admin
                TextInput::make('jabatan')
                    ->maxLength(255)
                    ->nullable(),
                DatePicker::make('tanggal_lahir')
                    ->nullable(),
                Textarea::make('alamat')
                    ->nullable()
                    ->columnSpanFull(), // Menggunakan seluruh lebar kolom
                TextInput::make('lat_lokasi_kerja')
                    ->numeric()
                    ->nullable(),
                TextInput::make('long_lokasi_kerja')
                    ->numeric()
                    ->nullable(),
                TextInput::make('radius_toleransi')
                    ->numeric()
                    ->default(50)
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('role')
                    ->badge() // Tampilkan sebagai badge
                    ->color(fn (string $state): string => match ($state) {
                        'admin' => 'danger',
                        'pegawai' => 'success',
                        default => 'gray',
                    })
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nip')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false), // Bisa disembunyikan/ditampilkan
                Tables\Columns\TextColumn::make('jabatan')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('tanggal_lahir')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true), // Sembunyikan secara default
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Filter untuk role
                Tables\Filters\SelectFilter::make('role')
                    ->options([
                        'admin' => 'Admin',
                        'pegawai' => 'Pegawai',
                    ]),
            ])
            ->actions([
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    // Hanya tampilkan user dengan role 'pegawai' di daftar, kecuali admin itu sendiri
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->when(auth()->user()->isAdmin(), function (Builder $query) {
                // Admin bisa melihat semua user
                return $query;
            })
            ->when(auth()->user()->isPegawai(), function (Builder $query) {
                // Pegawai hanya bisa melihat dirinya sendiri (jika resource ini diaktifkan untuk pegawai)
                return $query->where('id', auth()->id());
            })
            // Default: hanya tampilkan pegawai jika user bukan admin
            ->when(!auth()->user()->isAdmin(), function (Builder $query) {
                return $query->where('role', 'pegawai');
            });
    }
}