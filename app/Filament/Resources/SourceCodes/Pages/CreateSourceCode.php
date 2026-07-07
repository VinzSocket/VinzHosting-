<?php

namespace App\Filament\Resources\SourceCodes\Pages;

use App\Filament\Resources\SourceCodes\SourceCodeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSourceCode extends CreateRecord
{
    protected static string $resource = SourceCodeResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
