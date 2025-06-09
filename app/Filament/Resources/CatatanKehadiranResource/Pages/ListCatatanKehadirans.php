<?php

namespace App\Filament\Resources\CatatanKehadiranResource\Pages;

use App\Filament\Resources\CatatanKehadiranResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCatatanKehadirans extends ListRecords
{
    protected static string $resource = CatatanKehadiranResource::class;

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         Actions\CreateAction::make(),
    //     ];
    // }
}
