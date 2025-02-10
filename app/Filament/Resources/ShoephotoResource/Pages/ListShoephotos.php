<?php

namespace App\Filament\Resources\ShoephotoResource\Pages;

use App\Filament\Resources\ShoephotoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListShoephotos extends ListRecords
{
    protected static string $resource = ShoephotoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
