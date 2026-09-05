<?php

namespace App\Filament\Resources\Projects\Resources\ProjectTasks\Pages;

use App\Filament\Resources\Projects\Resources\ProjectTasks\ProjectTaskResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewProjectTask extends ViewRecord
{
    protected static string $resource = ProjectTaskResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
