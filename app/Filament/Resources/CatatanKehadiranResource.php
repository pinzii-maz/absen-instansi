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
use Filament\Forms;

class CatatanKehadiranResource extends Resource
{
    protected static ?string $model = CatatanKehadiran::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-check';
    protected static ?string $modelLabel = 'Persetujuan Izin';

    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Kolom 1: Nama Karyawan
                TextColumn::make('user.name')
                    ->label('Nama Karyawan')
                    ->searchable()
                    ->sortable(),

                // Kolom 2: Jenis Izin
                TextColumn::make('jenisKehadiran.name')
                    ->label('Jenis Izin'),

                // Kolom 3: Tanggal Mulai
                TextColumn::make('tanggal_masuk')
                    ->date('d M Y')
                    ->label('Tanggal Mulai')
                    ->sortable(),

                // Kolom 4: Tanggal Selesai
                TextColumn::make('tanggal_selesai_izin')
                    ->date('d M Y')
                    ->label('Tanggal Selesai'),

                // Kolom 5: Status (versi modern)
                TextColumn::make('status_izin')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'menunggu' => 'warning',
                        'disetujui' => 'success',
                        'ditolak' => 'danger',
                        default => 'gray',
                    }),

                // SOLUSI 1: Kolom Alasan Penolakan yang selalu tampil
               TextColumn::make('alasan_penolakan')
    ->label('Alasan Penolakan')
    ->limit(30)
    ->wrap()
    ->icon('heroicon-o-chat-bubble-bottom-center-text')
    ->toggleable(isToggledHiddenByDefault: true)
                    ->formatStateUsing(function (?string $state, CatatanKehadiran $record): string {
                        if ($record->status_izin !== 'ditolak') {
                            return '-';
                        }
                        return $state ?: '-';
                    }),

                // Kolom 7: Nama Approver
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
                ActionGroup::make([
                    Action::make('lihat_keterangan')
                        ->label('Lihat Keterangan')
                        ->icon('heroicon-o-chat-bubble-left-ellipsis')
                        ->color('gray')
                        ->modalContent(fn (CatatanKehadiran $record): View => view(
                            'filament.keterangan-izin-modal',
                            ['record' => $record],
                        ))
                        ->modalSubmitAction(false)
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
                        ->form([
                            Forms\Components\TextInput::make('alasan_penolakan')
                                ->label('Alasan Penolakan')
                                ->required()
                        ])
                        ->action(function (CatatanKehadiran $record, array $data) {
                            $record->update([
                                'status_izin' => 'ditolak',
                                'approved_by' => auth()->id(),
                                'alasan_penolakan' => $data['alasan_penolakan']
                            ]);
                            Notification::make()->title('Izin telah ditolak')->danger()->send();
                        })
                        ->visible(fn (?CatatanKehadiran $record): bool => $record && $record->status_izin === 'menunggu'),
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
            NavigationItem::make('Persetujuan Izin')
                ->group(static::getNavigationGroup())
                ->icon(static::getNavigationIcon())
                ->isActiveWhen(fn () => request()->routeIs(static::getRouteBaseName() . '.index'))
                ->url(static::getUrl('index')),

            NavigationItem::make('Rekapitulasi Kehadiran')
                ->group(static::getNavigationGroup())
                ->icon('heroicon-o-chart-bar-square')
                ->isActiveWhen(fn () => request()->routeIs(static::getRouteBaseName() . '.rekap-kehadiran'))
                ->url(static::getUrl('rekap-kehadiran')),
        ];
    }
}