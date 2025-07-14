<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DailyAttendanceResource\Pages;
use App\Filament\Resources\DailyAttendanceResource\RelationManagers;
use App\Models\CatatanKehadiran;
use Filament\Forms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;  
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;    
class DailyAttendanceResource extends Resource
{
    protected static ?string $model = CatatanKehadiran::class;
    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?string $modelLabel = 'Absensi Harian';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Nama Karyawan')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('jenisKehadiran.name')
                    ->label('Jenis Kehadiran'),
                TextColumn::make('tanggal_masuk')
                    ->label('Tanggal')
                    ->formatStateUsing(fn ($state) => \Carbon\Carbon::parse($state)->translatedFormat('d M Y'))
                    ->sortable(),
                TextColumn::make('jam_masuk')
                    ->label('Jam Masuk')
                    ->formatStateUsing(fn (?string $state) => $state ? \Carbon\Carbon::parse($state)->format('H:i:s') : '-')
                    ->alignCenter(),
                TextColumn::make('jam_pulang')
                    ->label('Jam Pulang')
                    ->formatStateUsing(fn (?string $state) => $state ? \Carbon\Carbon::parse($state)->format('H:i:s') : '-')
                    ->alignCenter(),
                TextColumn::make('status_izin')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'menunggu' => 'warning',
                        'disetujui' => 'success',
                        'ditolak' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('approver.name')
                    ->label('Diproses Oleh')
                    ->default('-')
                    ->visible(fn (?CatatanKehadiran $record): bool => $record && $record->status_izin !== 'menunggu'),
            ])
            ->filters([
                SelectFilter::make('status_izin')
                    ->label('Filter Status')
                    ->options([
                        'menunggu' => 'Menunggu',
                        'disetujui' => 'Disetujui',
                        'ditolak' => 'Ditolak',
                    ])
                    ->default('menunggu'),
            ])
            ->actions([
                \Filament\Tables\Actions\DeleteAction::make()
                    ->label('Hapus Absen')
                    ->requiresConfirmation()
                    ->modalHeading('Hapus Absensi Harian')
                    ->modalSubheading('Apakah Anda yakin ingin menghapus data absensi ini?')
                    ->modalButton('Ya, Hapus'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->whereHas('jenisKehadiran', function ($query) {
            $query->whereIn('code', ['H', 'T']);
        });
    }

    public static function getRelations(): array
    {
        return [
            
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDailyAttendances::route('/'),
        ];
    }
}
