<?php

namespace App\Filament\Resources\ShoephotoResource\Pages;

use App\Filament\Resources\ShoephotoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditShoephoto extends EditRecord
{
    protected static string $resource = ShoephotoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
