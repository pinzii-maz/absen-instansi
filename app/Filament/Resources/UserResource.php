<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Tables\Columns\IconColumn;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;  
use Filament\Forms\Components\Toggle;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                ->label('Nama Pegawai')
                ->required(),
            TextInput::make('email')
                ->label('Email')
                ->email()
                ->required(),
            
            // INI BAGIAN PENTINGNYA: Dropdown untuk Role
            Select::make('role')
                ->options([
                    // Masukkan semua pilihan role dari migrasi Anda di sini
                    'admin' => 'Admin',
                    'kepala_biro' => 'Kepala Biro',
                    'kepala_bagian_perencanaan_dan_kepegawaian' => 'Kepala Bagian Perencanaan dan Kepegawaian',
                    'kepala_bagian_protokol' => 'Kepala Bagian Protokol',
                    'kepala_bagian_materi_dan_komunikasi_pimpinan' => 'Kepala Bagian Materi dan Komunikasi Pimpinan',
                    'kepala_sub_bagian_tata_usaha' => 'Kepala Sub Bagian Tata Usaha',
                    'analisi_kebijakan_ahli_muda' => 'Analisi Kebijakan Ahli Muda',
                    'pranata_hubungan_masyarakat_ahli_muda' => 'Pranata Hubungan Masyarakat Ahli Muda',
                    'pelaksana' => 'Pelaksana',
                ])
                ->required(),

            Toggle::make('is_admin')
                ->label('Jadikan Admin?')
                ->onColor('success')
                ->offColor('danger'),

            // Field password yang hanya di-update jika diisi
            TextInput::make('password')
                ->password()
                ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                ->dehydrated(fn ($state) => filled($state))
                ->required(fn (string $context): bool => $context === 'create')
                ->label('Password Baru (Opsional)'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                   TextColumn::make('name')
                ->label('Nama Pegawai')
                ->searchable()
                ->sortable(),
            TextColumn::make('role')
                ->label('Jabatan')
                ->badge()
                ->searchable(),
            TextColumn::make('email')
                ->label('Email')
                ->searchable(),
            // Kolom baru untuk menampilkan status admin
            IconColumn::make('is_admin')
                ->label('Admin?')
                ->boolean(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
}
