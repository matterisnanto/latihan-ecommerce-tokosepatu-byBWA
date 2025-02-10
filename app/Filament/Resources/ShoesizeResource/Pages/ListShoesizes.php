<?php

namespace App\Filament\Resources\ShoesizeResource\Pages;

use App\Filament\Resources\ShoesizeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListShoesizes extends ListRecords
{
    protected static string $resource = ShoesizeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
