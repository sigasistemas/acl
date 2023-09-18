<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
namespace Callcocam\Acl\Resources\AccessGroupResource\Pages;

use Callcocam\Acl\Resources\AccessGroupResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ManageAccessGroups extends ListRecords
{
    protected static string $resource = AccessGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
