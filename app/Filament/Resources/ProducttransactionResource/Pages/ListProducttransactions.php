<?php

namespace App\Filament\Resources\ProducttransactionResource\Pages;

use App\Filament\Resources\ProducttransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProducttransactions extends ListRecords
{
    protected static string $resource = ProducttransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
