<?php

namespace App\Filament\Resources\ProducttransactionResource\Pages;

use App\Filament\Resources\ProducttransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProducttransaction extends EditRecord
{
    protected static string $resource = ProducttransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
