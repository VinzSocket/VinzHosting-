<?php

namespace App\Filament\Resources\SourceCodes\Pages;

use App\Filament\Resources\SourceCodes\SourceCodeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSourceCode extends EditRecord
{
    protected static string $resource = SourceCodeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
