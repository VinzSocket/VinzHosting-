<?php

namespace App\Filament\Resources\SourceCodes\Pages;

use App\Filament\Resources\SourceCodes\SourceCodeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSourceCodes extends ListRecords
{
    protected static string $resource = SourceCodeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
