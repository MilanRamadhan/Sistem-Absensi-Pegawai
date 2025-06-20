<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IzinTidakHadirResource\Pages;
use App\Filament\Resources\IzinTidakHadirResource\RelationManagers;
use App\Models\IzinTidakHadir;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload; // Import FileUpload
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage; // Untuk menghapus file

class IzinTidakHadirResource extends Resource
{
    protected static ?string $model = IzinTidakHadir::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Manajemen Kehadiran';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                DatePicker::make('tanggal_mulai')
                    ->required(),
                DatePicker::make('tanggal_selesai')
                    ->required(),
                Select::make('jenis_izin')
                    ->options([
                        'Sakit' => 'Sakit',
                        'Pribadi' => 'Pribadi',
                        'Cuti' => 'Cuti',
                    ])
                    ->required(),
                Textarea::make('alasan')
                    ->required()
                    ->maxLength(500)
                    ->columnSpanFull(),
                FileUpload::make('bukti_file')
                    ->label('Bukti File')
                    ->nullable()
                    ->disk('public') // Gunakan disk 'public'
                    ->directory('izin_bukti') // Simpan di storage/app/public/izin_bukti
                    ->acceptedFileTypes(['application/pdf', 'image/*']) // Hanya PDF dan gambar
                    ->maxSize(2048) // Maks 2MB
                    ->columnSpanFull(),
                Select::make('status_admin')
                    ->options([
                        'pending' => 'Pending',
                        'disetujui' => 'Disetujui',
                        'ditolak' => 'Ditolak',
                    ])
                    ->required()
                    ->default('pending')
                    ->columnSpanFull(),
                Textarea::make('catatan_admin')
                    ->nullable()
                    ->maxLength(500)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal_mulai')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal_selesai')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jenis_izin')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('alasan')
                    ->limit(50) // Batasi tampilan di tabel
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('bukti_file')
                    ->label('Bukti')
                    ->formatStateUsing(fn (string $state): string => Storage::url($state) ? '<a href="' . Storage::url($state) . '" target="_blank" class="text-primary-600 hover:underline">Lihat Bukti</a>' : '-')
                    ->html()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('status_admin')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'disetujui' => 'success',
                        'ditolak' => 'danger',
                        default => 'gray',
                    })
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status_admin')
                    ->options([
                        'pending' => 'Pending',
                        'disetujui' => 'Disetujui',
                        'ditolak' => 'Ditolak',
                    ]),
                Tables\Filters\SelectFilter::make('jenis_izin')
                    ->options([
                        'Sakit' => 'Sakit',
                        'Pribadi' => 'Pribadi',
                        'Cuti' => 'Cuti',
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
            'index' => Pages\ListIzinTidakHadirs::route('/'),
            'create' => Pages\CreateIzinTidakHadir::route('/create'),
            'edit' => Pages\EditIzinTidakHadir::route('/{record}/edit'),
        ];
    }
}