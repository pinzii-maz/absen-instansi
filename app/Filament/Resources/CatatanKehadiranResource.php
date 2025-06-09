<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CatatanKehadiranResource\Pages;
use App\Models\CatatanKehadiran;
use Filament\Forms\Form;
use Illuminate\Contracts\View\View;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup; 
use Filament\Navigation\NavigationItem; 
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

class CatatanKehadiranResource extends Resource
{
    protected static ?string $model = CatatanKehadiran::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-check';
    // protected static ?string $navigationLabel = 'Persetujuan Izin';
    // protected static ?string $navigationLabel = 'Manajemen Izin & Kehadiran';
    protected static ?string $modelLabel = 'Persetujuan Izin';

    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // GRUP INFO KARYAWAN & JENIS
                TextColumn::make('user.name')
                    ->label('Nama Karyawan')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('jenisKehadiran.name')
                    ->label('Jenis Izin'),

                // GRUP INFO TANGGAL
                TextColumn::make('tanggal_masuk')
                    ->date('d M Y')
                    ->label('Tanggal Mulai')
                    ->sortable(),

                TextColumn::make('tanggal_selesai_izin')
                    ->date('d M Y')
                    ->label('Tanggal Selesai'),

                // GRUP INFO STATUS & HASIL
                BadgeColumn::make('status_izin')
                    ->label('Status')
                    ->colors([
                        'warning' => 'menunggu',
                        'success' => 'disetujui',
                        'danger' => 'ditolak',
                    ]),
                
                // ✅ PENINGKATAN: Tampilkan nama approver
                TextColumn::make('approver.name')
                    ->label('Diproses Oleh')
                    ->default('-')
                    // ✅ LOGIKA DIPERBAIKI: Tampil jika status BUKAN 'menunggu'
                    ->visible(fn (?CatatanKehadiran $record): bool => $record && $record->status_izin !== 'menunggu'),
                
                
                // TextColumn::make('keterangan_izin')
                //     ->label('Keterangan')
                //     ->icon('heroicon-o-chat-bubble-left-ellipsis')
                //     ->limit(20)
                //     ->popover(), // <-- Keterangan akan muncul saat ikon di-klik
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
                // ✅ PENINGKATAN: Semua aksi digabung dalam satu dropdown (...)
                ActionGroup::make([

                    Action::make('lihat_keterangan')
                    ->label('Lihat Keterangan')
                    ->icon('heroicon-o-chat-bubble-left-ellipsis')
                    ->color('gray')
            // Tampilkan konten di dalam modal
                    ->modalContent(fn (CatatanKehadiran $record): View => view(
                    'filament.keterangan-izin-modal',
                    ['record' => $record],
                    ))
            ->modalSubmitAction(false) // Sembunyikan tombol submit/create
            ->modalCancelActionLabel('Tutup'),

                    Action::make('setujui')
                        ->label('Setujui')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(function (CatatanKehadiran $record) {
                            $record->update(['status_izin' => 'disetujui', 'approved_by' => auth()->id()]);
                            Notification::make()->title('Izin berhasil disetujui')->success()->send();
                        })
                        ->visible(fn (?CatatanKehadiran $record): bool => $record && $record->status_izin === 'menunggu'),

                    Action::make('tolak')
                        ->label('Tolak')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->action(function (CatatanKehadiran $record) {
                            $record->update(['status_izin' => 'ditolak', 'approved_by' => auth()->id()]);
                            Notification::make()->title('Izin telah ditolak')->danger()->send();
                        })
                        ->visible(fn (?CatatanKehadiran $record): bool => $record && $record->status_izin === 'menunggu'),
                    
                    // Action::make('lihat_dokumen')
                    //     ->label('Lihat Dokumen')
                    //     ->icon('heroicon-o-document-text')
                    //     ->color('gray')
                    //     ->url(fn (CatatanKehadiran $record): string => Storage::url($record->file_pendukung_izin), shouldOpenInNewTab: true)
                    //     ->visible(fn (?CatatanKehadiran $record): bool => $record && $record->file_pendukung_izin !== null),
                ])
            ])
            ->bulkActions([]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->whereHas('jenisKehadiran', function ($query) {
            $query->whereNotIn('code', ['H', 'P']);
        });
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCatatanKehadirans::route('/'),

            'rekap-kehadiran' => Pages\RekapKehadiran::route('/rekap-kehadiran'),
        ];
    }

     public static function getNavigationItems(): array
    {
        return [
            // Tab 1: Mengarah ke halaman 'list' (Persetujuan Izin)
            NavigationItem::make('Persetujuan Izin')
                ->group(static::getNavigationGroup())
                ->icon(static::getNavigationIcon())
                ->isActiveWhen(fn () => request()->routeIs(static::getRouteBaseName() . '.index'))
                ->url(static::getUrl('index')),

            // Tab 2: Mengarah ke halaman 'rekap-kehadiran'
            NavigationItem::make('Rekapitulasi Kehadiran')
                ->group(static::getNavigationGroup())
                ->icon('heroicon-o-chart-bar-square') // Kita beri icon berbeda
                ->isActiveWhen(fn () => request()->routeIs(static::getRouteBaseName() . '.rekap-kehadiran'))
                ->url(static::getUrl('rekap-kehadiran')),
        ];
    }
}
